<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search['q'] = request('q');
        $search['precision'] = request('precision') ?? 'preciso';

        if (request('code')) {
            $product = Product::where('code', request('code'))->with('taxes')->first();
            if (request()->wantsJson()) {
                return response($product, 200);
            }
        }
        if (request('q')) {
            $products = Product::search($search)->with(['taxes' => function ($query) {
                $query->orderBy('tarifa', 'desc'); // mayor a menor tarifa
            }])->latest()->paginate(10);
        } else {
            $products = Product::latest()->with(['taxes' => function ($query) {
                $query->orderBy('tarifa', 'desc'); // mayor a menor tarifa
            }])->paginate(10);
        }

       

        if (request()->wantsJson()) {
            return response($products, 200);
        }

        $totalInventario = Product::sum('quantity');
        // $valorInventario = Product::all()->sum(function ($product) {
        //     return $product->priceWithTaxes * $product->quantity;
        // });
        // $costoInventario = Product::all()->sum(function ($product) {
        //     return $product->purchase_price * $product->quantity;
        // });
        $valorInventario = \DB::table('products')
                ->select(\DB::raw('SUM(priceWithTaxes * quantity) as valor_inventario'))
                ->first()->valor_inventario;

        $costoInventario = \DB::table('products')
                ->select(\DB::raw('SUM(purchase_price * quantity) as costo_inventario'))
                ->first()->costo_inventario;
        
        return view('products.index', compact('products', 'totalInventario', 'valorInventario', 'costoInventario', 'search'));
    }

    public function export()
    {
        $filter = request('filter');

        return \Excel::download(new ProductsExport($filter), 'products.xlsx');
    }

    public function import(Request $request){
        $file = $request->file('archivo');
        \Excel::import(new ProductsImport, $file);
        return redirect('/products');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $this->authorize('create', Product::class);

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate(request(), [
            'code' => 'required',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'subquantity' => 'required|numeric',
            'price' => 'required|numeric',
            'photo' => 'mimes:jpg,jpeg,bmp,png|max:1000'
        ]);

        $data = $this->prepareData(request()->all());

        $product = Product::create($data);
    

        if ($photo = request()->file('photo')) {
            $this->uploadPhoto($photo, $product);
        }

        flash('Producto creado', 'success');

        return redirect('/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $product->load('taxes');
        return view('products.edit', compact('product'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $this->validate(request(), [
            'code' => 'required',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'subquantity' => 'required|numeric',
            'price' => 'required|numeric',
            'purchase_price' => 'numeric',
            'utilidad' => 'numeric',
            'photo' => 'mimes:jpg,jpeg,bmp,png|max:1000'
        ]);

        $data = $this->prepareData(request()->all());

        $product->fill($data);
        $product->save();

        if (isset($data['taxes'])) {
            $product->taxes()->sync($data['taxes']);
        }else{
            $product->taxes()->sync([]);
        }
        
        $product->calculatePriceWithTaxes();

        if ($photo = request()->file('photo')) {
            $this->uploadPhoto($photo, $product);
        }

        flash('Producto actualizado', 'success');

        return Redirect('/products');
    }

    public function duplicate(Request $request, Product $product)
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $newProduct = $product->replicate();
        $newProduct->code = $request->input('code');
        $newProduct->name = $request->input('name');
        $newProduct->quantity = $request->input('quantity');
        $newProduct->price = $request->input('price');
        $newProduct->save();

        // Sync taxes from the original product
        $newProduct->taxes()->sync($product->taxes->pluck('id'));
        $newProduct->calculatePriceWithTaxes();

        return response()->json([
            'message' => 'Producto duplicado exitosamente',
            'product' => $newProduct,
        ]);
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $product->quantity = $request->input('quantity');
        $product->save();

        return response()->json([
            'message' => 'Cantidad del producto actualizada correctamente',
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('update', $product);

        $product->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/products');
    }

    public function prepareData($data)
    {
        if (empty($data['provider_id'])) {
            $data['provider_id'] = 0;
        }
        if (empty($data['purchase_price'])) {
            $data = Arr::except($data, ['purchase_price']);
        }
        if (empty($data['min'])) {
            $data = Arr::except($data, ['min']);
        }
        if (empty($data['max'])) {
            $data = Arr::except($data, ['max']);
        }
        if (empty($data['taxes'])) {
            $data = Arr::except($data, ['taxes']);
        }

        return $data;
    }

    public function uploadPhoto($file, $product)
    {
        $mimes = ['jpg', 'jpeg', 'bmp', 'png'];

        $ext = strtolower($file->guessClientExtension());

        if (in_array($ext, $mimes)) {
            $storedPath = $this->optimizeAndStorePhoto($file, $ext);
           
            $product->update([
                "photo_path" => $storedPath ?: $file->store('photos', 'public')
            ]);
        }

        return $product;
    }

    private function optimizeAndStorePhoto($file, $ext)
    {
        $realPath = $file->getRealPath();

        if (! $realPath || ! function_exists('getimagesize')) {
            return null;
        }

        $imageSize = @getimagesize($realPath);

        if (! $imageSize || empty($imageSize[0]) || empty($imageSize[1])) {
            return null;
        }

        $source = $this->createImageResource($realPath, $ext);

        if (! $source) {
            return null;
        }

        $originalWidth = (int) $imageSize[0];
        $originalHeight = (int) $imageSize[1];
        $maxWidth = 1200;
        $maxHeight = 1200;
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight, 1);

        $newWidth = max(1, (int) round($originalWidth * $ratio));
        $newHeight = max(1, (int) round($originalHeight * $ratio));

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        if ($ext === 'png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $fileName = uniqid('product_', true) . '.' . $ext;
        $relativePath = 'photos/' . $fileName;
        $destinationPath = storage_path('app/public/' . $relativePath);

        if (! is_dir(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0755, true);
        }

        $saved = false;

        if (($ext === 'jpg' || $ext === 'jpeg') && function_exists('imagejpeg')) {
            $saved = imagejpeg($resized, $destinationPath, 80);
        } elseif ($ext === 'png' && function_exists('imagepng')) {
            $saved = imagepng($resized, $destinationPath, 7);
        } elseif ($ext === 'bmp' && function_exists('imagebmp')) {
            $saved = imagebmp($resized, $destinationPath);
        }

        imagedestroy($resized);
        imagedestroy($source);

        return $saved ? $relativePath : null;
    }

    private function createImageResource($realPath, $ext)
    {
        if (($ext === 'jpg' || $ext === 'jpeg') && function_exists('imagecreatefromjpeg')) {
            return @imagecreatefromjpeg($realPath);
        }

        if ($ext === 'png' && function_exists('imagecreatefrompng')) {
            return @imagecreatefrompng($realPath);
        }

        if ($ext === 'bmp' && function_exists('imagecreatefrombmp')) {
            return @imagecreatefrombmp($realPath);
        }

        return null;
    }

}
