<div id="record_sales">
    <?= form_open('sale/add', array('id' => 'add-sale-form')) ?>
    <div class="col-left">        
        <?= form_input('sales_number', $sales_number, 'id="sales_number" disabled') ?>
        <p class="blue">your unique Sales Number</p>
        <p class="red">write it on your sales docket</p>

        <?= form_input('invoice_number', set_value('invoice_number')) ?>
        <p class="blue">enter the invoice or docket number</p>

        <?= form_input('sale_date', set_value('sale_date')) ?>
        <p class="blue">enter the date of sale</p>

        <p>Click on the appropriate product category on the right to unfold the list of eligible products within each category.</p>

        <p>For every sale you enter within 10 days of the sale date you will earn 20% more point (Value A).</p>

        <?= form_submit('submit', 'continue') ?>

        <div id="callout">
            <p>Keep your docket in a safe place as it will be required for verification if you win a prize</p>
        </div>
    </div>

    <div class="col-right">
        <?php foreach ($product_types as $product_type): ?>
            <section class="product-category cat-<?= $product_type->product_type_id ?>">
                <header>
                    <p><?= $product_type->product_type_name ?></p>
                </header>

                <table>
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Value A</th>
                            <th>Value B</th>
                            <th># sold</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; foreach ($product_type->products as $product): ?>
                            <tr class="row-<?= $i ?>">
                                <td><?= $product->product_name ?></td>
                                <td><?= $product->product_points_a ?></td>
                                <td><?= $product->product_points_b ?></td>
                                <td><?= form_input('quantity_' . $product->product_id, set_value('quantity_' . $product->product_id, '0'), 'class="quantity-input" size="2"') ?></td>
                            </tr>
                        <?php $i = 1 - $i; endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endforeach; ?>
    </div>
    <?= form_close() ?>
</div>