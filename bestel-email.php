<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>Bestelling bij delga.be</title>
</head>
<body style="background-color:#F5F6F8;font-family:-apple-system, BlinkMacSystemFont, 'segoe ui', roboto, oxygen, ubuntu, cantarell, 'fira sans', 'droid sans', 'helvetica neue', Arial, sans-serif;box-sizing:border-box;font-size:16px;">
<div style="padding:20px;background-color:#fff;margin:20px;box-sizing:border-box;font-size:16px;">
    <h1 style="padding:40px;box-sizing:border-box;font-size:24px;color:#394453;background-color:#EBFFD7;margin:0;"><img src="http://test.delga.be/images/delga_gif.gif" height="80"/></h1>
    <h1 style="padding:40px;box-sizing:border-box;font-size:24px;color:#394453;margin:0;">Bedankt voor uw bestelling <?=$voornaam?></h1>
    <p style="padding:40px 40px 20px 40px;margin:0;box-sizing:border-box;font-size:16px;">Uw bestelling is ontvangen en wordt verwerkt, u vindt de details van uw order hieronder.</p>
    <h3 style="padding:20px 40px;margin:0;color:#394453;box-sizing:border-box;">Order #<?=$order_nr?></h3>
    <div style="box-sizing:border-box;padding:0 40px;">
        <table style="border-collapse:collapse;width:100%;">
            <thead style="border-bottom:1px solid #eee;">
            <tr>
                <td style="padding:25px 0;">Product</td>
                <td>Prijs</td>
                <td>Aantal</td>
                <td>Totaal</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($producten_winkelmand as $product): ?>
                <tr>
                    <td style="padding:25px 0;"><?=$product['meta']['product_naam']?><br><?=$product['opties']?></td>
                    <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                        <td>€ <?= number_format($product['optie_eenheidsprijs'], 2) ?></td>
                    <?php else: ?>
                        <td>€ <?= number_format($product['meta']['eenheidsprijs'], 2) ?></td>
                    <?php endif; ?>
                    <td><?=$product['aantal']?></td>
                    <?php if ($product['optie_eenheidsprijs'] > 0): ?>
                        <td>€ <?= number_format($product['optie_eenheidsprijs'] * $product['aantal'], 2) ?></td>
                    <?php else: ?>
                        <td>€ <?= number_format($product['meta']['eenheidsprijs'] * $product['aantal'], 2) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p style="text-align:right;margin:0;box-sizing:border-box;font-size:18px;padding:20px 0;">
            Totaal <span style="padding-left:25px;">€ <?=number_format($subtotaal,2)?></span> <small>(Inclusief € 6 levering)</small>
        </p>
    </div>
    <h2 style="padding:20px 40px;margin:0;color:#394453;box-sizing:border-box;">Uw gegevens</h2>
    <p style="padding:20px 40px 60px 40px;margin:0;box-sizing:border-box;font-size:16px;">
        <?=$voornaam?>&nbsp;<?=$achternaam?><br>
        Facturatieadres:&nbsp;<?=$order_adres?><br>
        Leveringsadres:&nbsp;<?=$order_adres_2?>
    </p>
<h1 style="padding:40px;box-sizing:border-box;font-size:24px;color:#394453;background-color:#EBFFD7;margin:0;" align="right">delga.be &copy; 2021</h1>
</div>
</body>
</html>
