
 <expense-form
    :current-expense="{{ json_encode(isset($expense) ? $expense : '')  }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    >
</expense-form>