
 <product-providers-form
    :current-product-provider="{{ json_encode(isset($productprovider) ? $productprovider : '')  }}"
    :providers="{{ json_encode($providers) }}"

    >
</product-providers-form>