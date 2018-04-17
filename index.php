<?php

require_once __DIR__ . '/vendor/autoload.php';

$domain_list = require __DIR__.'/config/list.php';

$domain = $_GET[ 'domain' ];


?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://local.insune.co/elements/logo/insune.com/logo-original.ico">

    <meta name="description"
          content="Бесплатный Whois-сервис для проверки владельца доменного имени или IP-адреса. Без капчи и ограничений. Поддержка международных, национальных и новых доменных имён.">
    <meta name="keywords"
          content="домен, домены, купить домен, доменное имя, доменные имена, регистрация домена, бесплатный домен, проверить домен, занятость домена, reg ru, рег ру, nic ru, ник ру, rucenter, ru center, namecheap, неймчип, дешёвые домены, дешевые домены, зарегистрировать домен, ru домен, ру домен, рф домен, su домен, whois, domain, source, .ru, .su, .com, .net, .org, .info, .biz, .us, .co.uk, gtld, icann, registrar, domain name, nserver, домен, зона, сервер, регистратор, занят, свободен, владелец"/>
    <meta name="copyright" content="Insune Group - insune.co">

    <title>Whois-сервис - Россия | Проверка владельца домена</title>

    <meta property="title" content="Whois-сервис - Россия | Проверка владельца домена"/>
    <meta property="url" content="https://whoisinfo.ru"/>
    <meta property="image" content="https://local.insune.co/elements/logo/insune.com/logo-original.png"/>

    <meta name="google-site-verification" content="de87FT-eNa5rl3xZ0gkVrncwIo3WqChE8beeHy_5Jsc"/>
    <meta name="yandex-verification" content="a29337686e13fec6"/>
    <meta name="msvalidate.01" content="DE9AD9612B9197F87CB907F0851A488E"/>

    <link rel="preconnect" href="//local.insune.co/">

    <link href="https://local.insune.co/library/bootstrap/v4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">
<!-- ://////////////////////////////: | BODY | ://////////////////////////////: -->

<div class="container pt-4">

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <br>
            <h5>Введите доменное имя или IP-адрес</h5>
            <br>
            <div class="text-center">

                <form action="<?= $_SERVER[ 'PHP_SELF' ]; ?>">
                    <div class="input-group input-group-lg">

                        <input type="text" class="form-control" placeholder="domain.ru / 1.23.45.67"
                               aria-label="domain.ru / 1.23.45.67" name="domain" id="domain" value="<?= $domain; ?>">

                        <div class="input-group-append">
                            <input type="submit" class="btn btn-outline-secondary" value=">"></input>
                        </div>
                    </div>
                </form>

            </div>


            <div class="alert alert-light" role="alert">
                <?php
                if ($domain) {
                    $domain = trim($domain);
                    if (substr(strtolower($domain), 0, 7) == "http://") {
                        $domain = substr($domain, 7);
                    }
                    if (substr(strtolower($domain), 0, 4) == "www.") {
                        $domain = substr($domain, 4);
                    }
                    $validate = new \App\Validate();
                    $whois    = new \App\Whois($domain_list);

                    if ($validate->isIP($domain)) {
                        $result = $whois->ip($domain);
                    } elseif ($validate->isDomain($domain)) {
                        $result = $whois->domain($domain);
                    } else {
                        echo("Неправильно введен домен или IPv4. Повторите запрос.<br><br>Если Вы ввели в поле домен с протоколом или ссылкой, пожалуйста -<br>удалите ненужную информацию и оставьте домен в виде: <b>example.ru</b><br><br>Если данная ошибка продолжает появляться - свяжитесь с тех.админом.");
                    }
                    echo "<pre>\n" . $result . "\n</pre>\n";
                }
                ?>
            </div>


        </div>

        <div class="col-md-6 col-xs-6">
            <br>
            <hr>
            <br>
            <p><a href=""><b>WhoisInfo.ru</b></a> - веб-инструмент для проверки занятости домена или получения
                информации о его владельце. Введите интересующий Вас домен в "поле" выше и получите информацию в течении
                1 сек.</p>
            <br>
            <a href="https://github.com/abcdtools">См. этот проект на Гитхабе</a>
        </div>
        <div class="col-md-6 col-xs-6">
            <br>
            <hr>
            <br>
            <p>Сервис поддерживает проверку владельцев доменных имён и блоков IP-адресов. Поддерживаются международные и
                национальные домены.
                <br><br>
                Версия: v1.0.0-beta.v16 (открытая бета)
                <br>
                Дата релиза проекта: 16 апреля 2018 г.
                <br>
                В случае чего - <a class="text-muted" href="mailto:tech.admin@insune.com?subject=Почините WhoisInfo.ru">свяжитесь
                    с тех.админом</a>.
            </p>
        </div>
    </div>

</div>


<br><br>

<!--
	  Bootstrap, JQuery, Popper, FontAwesome 5 and other
	  ==================================================
	  Based at Insune.Storage for Insune Group Projects
	  -->

<script src="https://local.insune.co/library/jquery/v3.3.1/slim.min.js"></script>
<script>window.jQuery || document.write('<script src="https://local.insune.co/library/jquery/v3.3.1/slim.min.js"><\/script>')</script>
<script src="https://local.insune.co/library/popper/v1.13.0/popper.min.js"></script>

<script src="https://local.insune.co/library/bootstrap/v4.0.0/js/bootstrap.min.js"></script>

<!-- ://////////////////////////////: | BODY | ://////////////////////////////: -->
</body>

</html>
