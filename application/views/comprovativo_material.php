<style>
    td {
        font-size: 11px;
    }
</style>
<table style="border-collapse: collapse; width: 100%;" border="2">
    <tbody>
        <tr>
            <td style="width: 50%;">
                <b>Carga</b><br><br>
                PTFIRE&reg;<br>
                <?= $fornecimento['instalacao'] ?><br>
                <?= $fornecimento['morada_armazem'] ?><br>
                234 246 213
            </td>
            <td style="width: 50%; ">
                <b>Descarga</b><br><br>
                <?= $fornecimento['cliente'] ?><br>
                <?= $fornecimento['instalacao'] ?><br>
                <?= $fornecimento['morada'] ?>, <?= $fornecimento['cp'] ?><br>
                NIF: <?= $fornecimento['nif'] ?><br>
                <?= $fornecimento['telefone'] ?><br>
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table style="border-collapse: collapse; width: 100%;" border="2">
    <thead>
        <tr>
            <td border="0.5" style="width: 14.6667%; font-size:small"><b>Referência</b></td>
            <td border="0.5" style="width: 22.6667%; font-size:small"><b>Artigo</b></td>
            <td border="0.5" style="width: 12.6667%; font-size:small"><b>Qnt.</b></td>
            <td border="0.5" style="width: 12.6667%; font-size:small"><b>Pr Unit.</b></td>
            <td border="0.5" style="width: 22.6667%; font-size:small"><b>Fotografia</b></td>
            <td border="0.5" style="width: 14.6667%; font-size:small"><b>Total</b></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($artigos as $art) : ?>
            <tr>
                <td border="0.5" style="width: 14.6667%;"><?= $art['referencia'] ?></td>
                <td border="0.5" style="width: 22.6667%;"><?= $art['artigo'] ?></td>
                <td border="0.5" style="width: 12.6667%;"><?= $art['quantidade'] ?></td>
                <td border="0.5" style="width: 12.6667%;"><?= $art['preco'] ?> €</td>
                <td border="0.5" style="width: 22.6667%;"><img src="./recourses/images/products/<?= $art['fotografia1'] ?>" alt="<?= $art['artigo'] ?>"></td>
                <td border="0.5" style="width: 14.6667%;"><?= $art['preco'] * $art['quantidade'] ?> €</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
