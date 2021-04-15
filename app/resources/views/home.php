<!doctype html>
<html lang="uk">

<head>
    <meta charset="utf-8">
    <title>Англо-український перекладач ІТ слів</title>
    <meta name="description" content="Convert text to hyphen-case online">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <style>
        html {
            font-family: sans-serif;
            line-height: 1.15;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        h1 {
            font-size: 2em;
            margin: .67em 0
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: sans-serif;
            font-size: 100%;
            line-height: 1.15;
            margin: 0
        }

        .wrap {
            max-width: 40em;
            margin: 0 auto;
            padding: 1em
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        .mt-2 {margin-top: 1rem}


        input[type=search] {
            width: 70%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
        }

        input[type=submit] {
            width: 20%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
        h1 a{text-decoration: none; color: black}
    </style>
</head>

<body>

<div class="wrap">
    <h1><a href="/">Англо-український перекладач ІТ слів</a></h1>

    <form>

        <input autofocus list="search_list" type="search" id="search_input" name="q" placeholder="Що шукаємо?" value="<?=htmlspecialchars($_REQUEST['q']??'', ENT_QUOTES, 'UTF-8', false)?>">
        <datalist id="search_list">
        </datalist>
        <input type="submit">
    </form>

    <?php if (isset($_REQUEST['q'])): ?>

        <?php if ($data): ?>

            <table class="mt-2">
                <tr>
                    <th title="український переклад слова">укр</th>
                    <th title="ідентифікатор рядку перекладу в додатку">ідентифікатор</th>
                    <th title="андроїд додаток, де взяте це слово">додаток</th>
                </tr>

                <?php foreach ($data as $item): ?>

                    <tr>
                        <td><?= $item['word_uk_name'] ?></td>
                        <td><?= $item['item'] ?>
                        <?php if ($item['plural_group']):?>
                            <a target="_blank" rel="noreferrer" href="/?plural_group=<?=$item['plural_group']?>">[множина]</a>
                        <?php endif;?>
                        </td>
                        <td>
                            <a href="https://play.google.com/store/apps/details?id=<?= $item['app_id'] ?>&hl=uk"
                               target="_blank" rel="noopener">
                                <?= $item['app_name'] ?>
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>
        <?php else: ?>
        <p>Такого слова нема в нашій базі</p>
        <?php endif; ?>

    <?php elseif($plurals):?>

        <table class="mt-2">
            <tr>
                <th>множина</th>
                <th>англ</th>
                <th>укр</th>
            </tr>

            <?php foreach ($plurals as $plural=>$items): ?>

                <tr>
                    <td><?= $plural ?></td>
                    <td><?= $items['en'] ??'' ?></td>
                    <td><?= $items['uk'] ??'' ?></td>
                </tr>

            <?php endforeach; ?>

        </table>


    <?php endif; ?>

    <p>
        <small>Переклад взятий з найпопулярніших додатків Андроїд, включаючи chrome, facebook, twitter та інші.</small>
    </p>
    <p><small><b>API</b> Для видачі у форматі json додайте параметр format=json до адреси. <a target="_blank" rel="noopener" href="https://github.com/AucT/translator">github</a></small></p>


</div>

<script src="/app.js"></script>
</body>
</html>