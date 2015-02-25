<!DOCTYPE html>
<html>
    <head>
        <title>Sample Bootils Usage</title>
        <link href="http://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet" type="text/css">
        <style type="text/css">
            /* demo page styles */
            body {
                background:#e9e9e9;
                margin:0;
                padding:0;
                font-family: 'Raleway', sans-serif;
                color:#222;
                font-size: 18px;
                line-height: 1.5em;
            }
            h1,h2,h3,p,ol,ul{
                width:80%;
                margin-left:auto;
                margin-right:auto;
                font-weight:300;
            }
            h1{
                color:#a71826;
            }
            h2 {
                font-weight:500;
            }
            b {
                color:#a71826;
                font-weight:300;
            }
            .code{
                background-color:#333;
                padding:10px;
                width:calc(80% - 20px);
                border-radius:5px;
                max-height:200px;
                color:#eddf49;
                overflow:auto;
                white-space:normal;
                font-family: sans;
                font-weight: normal;
                font-size: 12px;
            }
            .result{
                background-color:#fff;
                padding:10px;
                width:calc(80% - 20px);
                border-radius:5px;
                max-height:200px;
                color:#666;
                overflow:auto;
                white-space:normal;
                font-size: 14px;
                border: solid 1px #ccc;
                font-style: italic;
            }
        </style>
    </head>
    <body>

        <h1>Sample Bootils Usage</h1>

        <h2>Configuring Bootils</h2>
        <p>
            You can define optionals params for use in Bootils, in this sample the configuration is:
        </p>
        <p class="code">
            $_bootils['DEFAULT_DATE_FORMAT'] = '%A, %e de %B de %Y';<br />
            $_bootils['DEFAULT_COMA_SEPARATOR'] = ',';<br />
            $_bootils['DEFAULT_THOUSAND_SEPARATOR'] = '.';<br />
            $_bootils['ERROR_REPORTING']=true;<br />
            $_bootils['DISPLAY_ERRORS']=true;
        </p>
        <?php 
        $_bootils['DEFAULT_DATE_FORMAT'] = '%A, %e de %B de %Y';
        $_bootils['DEFAULT_COMA_SEPARATOR'] = ',';
        $_bootils['DEFAULT_THOUSAND_SEPARATOR'] = '.';
        $_bootils['ERROR_REPORTING']=true;
        $_bootils['DISPLAY_ERRORS']=true;
        ?>
        <h2>Initializing Bootils</h2>
        <p>
            To start Just require it!
        </p>
        <p class="code">
            require_once 'bootils/start.bootils.php';
        </p>
        <!-- PHP Bootils require_once here -->
        <?php require_once 'bootils/start.bootils.php';?>

        <h2>Working with languages and dates</h2>
        <p>
            If you work with languages and dates, most likely need to use the locales installed on the server, bootils includes a function to give us work
        </p>

        <h3>User languages</h3>
        <p>
            If your website has several languages, you can ask, what language preferences the user has with the included function in bootils
        </p>
        <p class="code">
            $usr_lng = userLanguage();
        </p>
        <p class="result">
            <b>Your languages preferences:</b>
            <br />
            <?php var_dump(userLanguage()); ?>
        </p>
        <p>
            With this information, you can compare with your language and apply the most appropriate locales for the user, if your website is multilingual, sure you have the appropriate list of locales for each language. For our example we defined three languages, but must be variations of same language, remember the order preference is important. Our sample: <b>'ca_ES.utf8,es_ES.utf8,en_EN.utf8'</b> (Catalan, Spanish and English)
        </p>

        <h3>Define locales</h3>
        <p>
            The easiest part is defined locales for our example we have chosen three languages, but may be variations of the same language, it is important to maintain the order of preference in case they are different languages.
        </p>
        <p class="code">
            $locale=defineLocale('ca_ES.utf8,es_ES.utf8,en_EN.utf8');
        </p>
        <!-- PHP locales defineds here -->
        <?php $locale=defineLocale('ca_ES.utf8,es_ES.utf8,en_EN.utf8'); ?>
        <p>
            $locale variable contains the value of the LOCALE finally defined
        </p>
        <p class="result">
            <b>Current locale defined:</b>
            <br />
            <?php echo $locale; ?>
        </p>

        <h3>Print current date</h3>
        <p>
            When you set a locale can display the date with local format, using the unix2locale() function included in the Bootils
        </p>
        <p class="code">
            echo unix2locale();
        </p>
        <p class="result">
            <?php echo unix2locale();?>
        </p>

    </body>
</html>
