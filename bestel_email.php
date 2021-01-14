<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>Your Order Details</title>
</head>
<body style="background-color:#F5F6F8;font-family:-apple-system, BlinkMacSystemFont, 'segoe ui', roboto, oxygen, ubuntu, cantarell, 'fira sans', 'droid sans', 'helvetica neue', Arial, sans-serif;box-sizing:border-box;font-size:16px;">
<div style="background-color:#fff;margin:30px;box-sizing:border-box;font-size:16px;">
    <h1 style="padding:40px;box-sizing:border-box;font-size:24px;color:#ffffff;background-color:#50688c;margin:0;">Mercie voor uw bestelling</h1>
    <p style="padding:40px 40px 20px 40px;margin:0;box-sizing:border-box;font-size:16px;">Uw bestelling is ontvangen en wordt verwerkt, u vindt de details van uw order hieronder.</p>
    <h2 style="padding:20px 40px;margin:0;color:#394453;box-sizing:border-box;">Order #<?=$order_nr?></h2>
    <div style="box-sizing:border-box;padding:0 40px;">
        <table style="border-collapse:collapse;width:100%;">
            <thead style="border-bottom:1px solid #eee;">
            <tr>
                <td style="padding:25px 0;">Product</td>
                <td>Prijs</td>
                <td>Aantal</td>
                <td style="text-align:right;">Totaal</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td style="padding:25px 0;"><?=$product['meta']['name']?><br><?=$product['options']?></td>
                <td><?=isset($product['options_price']) ? number_format($product['options_price'],2) : number_format($product['meta']['price'],2)?></td>
                <td><?=$product['aantal']?></td>
                <td style="text-align:right;"><?=isset($product['options_price']) ? number_format($product['options_price'] * $product['aantal'],2) : number_format($product['meta']['price'] * $product['quantity'],2)?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p style="text-align:right;margin:0;box-sizing:border-box;font-size:18px;padding:20px 0;">
            Subtotaal <span style="padding-left:25px;"><?=number_format($subtotaal,2)?></span> <small>(Includes shipping)</small>
        </p>
    </div>
    <h2 style="padding:20px 40px;margin:0;color:#394453;box-sizing:border-box;">Uw gegevens</h2>
    <p style="padding:20px 40px 60px 40px;margin:0;box-sizing:border-box;font-size:16px;">
        <?=$voornaam?> <?=$achternaam?><br>
        <?=$adres_straat?><br>
        <?=$adres_nr?><br>
        <?=$adres_postcode?><br>
        <?=$adres_plaats?>
    </p>
</div>
</body>
</html>
