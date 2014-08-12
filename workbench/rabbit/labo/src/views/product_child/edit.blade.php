<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.product_child.update', $data->id))
    ->method('put');

echo FormProperty::section(
    'Product: ' . $product->id . ' - ' . $product->en_name . ', Category: ' . $category->id . ' - ' . $category->en_name
);

echo '<div class="row">
        <div class="col-md-6">';

echo Former::hidden('product_id')
    ->value($product->id);
echo Former::text('kh_name')
    ->value($data->kh_name)
    ->required();
echo Former::text('en_name')
    ->value($data->en_name)
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('normal_value')
    ->value($data->normal_value)
    ->required();

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>