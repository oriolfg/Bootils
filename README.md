# <a name="top"></a> [Bootils](http://bootils.oriolet.net)

With only one <b>include_once</b>, enjoy PHP popular libraries and more than 25 quick access basic functions

## Table of contents
* [Quick start](#start)
 *  [Start](#start)
 * [Configure](#config)
* [Libraries](#libraries)
 * [Kint](#kint)
 * [Swiftmailer](#swiftmailer)
* [Functions list](#functions)
* [What's included](#included)
* [License](#license)
* [Download](#download)

## <a name="start"></a> Quick start
[top](#top)

Bootils is easy! 

### <a name="start"></a> Start

Only require the start file and enjoy !!

```
require_once('bootils/start.bootils.php');
```

### <a name="config"></a> Configure

Edit config.bootils.php to configure bootils and customize it!!

#### Regional configuration

Use these options to fit "bootils" in your locale

```
$_bootils['LANGUAGE_LOCALE'] = 'ca_ES';// Default value is en_GB
$_bootils['DEFAULT_DATE_FORMAT'] = '%A, %e de %B de %Y';// Default value is %A %d %B %
$_bootils['DEFAULT_COMA_SEPARATOR'] = ',';// Default value is .
$_bootils['DEFAULT_THOUSAND_SEPARATOR'] = '.';// Default value is ,
```

#### Kint configuration

KINT can enable or disable as you think necessary

```
$_bootils['KINT'] = true;
// Don't like KINT?, you are free to delete the third/kint folder to save space
```

#### Swiftmailer configuration

You can enable or disable Swiftmail as you think necessary, if deactivated fastMail() function work just using php function to send mail()

```
$_bootils['SWIFTMAILER'] = true;
// Don't like SWIFT MAILER?, you are free to delete the third/swift folder to save space
```

#### General mail configuration

If you use Swiftmail or not, some mail settings can be configured

```
$_bootils['MAIL_CHARSET']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_CHARSET_PLAIN']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_CHARSET_HTML']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_SENDER_MAIL']="sender@example.org";// Default value is blank
$_bootils['MAIL_SENDER_NAME']="Sender Name";// Default value is blank
```

#### Smtp mail configuration

These functions simply set them, if Swiftmail is enabled

```
$_bootils['SMTP_HOST']="localhost";// Default value is localhost
$_bootils['SMTP_USER']="mailusername";// Default value is blank
$_bootils['SMTP_PASSWORD']="mailpassword";// Default value is blank
$_bootils['SMTP_PORT']=25;// Default value is 25

$_bootils['SMTP_ANTIFLOOD']=true;// For massive sending (default true)
$_bootils['SMTP_ANTIFLOOD_MAILS']=100;// number of emails between breaks (default 100)
$_bootils['SMTP_ANTIFLOOD_PAUSE']=30;// Seconds-long break before continuing (default 30)
```

#### Errors configuration

Define the errors you want to register, and if you want to display it on screen

```
$_bootils['ERROR_REPORTING']=true;
$_bootils['HIDE_ERROR'] = true;
$_bootils['HIDE_RECOVERABLE_ERROR'] = true;
$_bootils['HIDE_WARNING'] = true;
$_bootils['HIDE_PARSE'] = true;
$_bootils['HIDE_STRICT'] = true;
$_bootils['HIDE_NOTICE'] = true;
$_bootils['HIDE_USER_DEPRECATED'] = true;
$_bootils['HIDE_DEPRECATED'] = true;
$_bootils['DISPLAY_ERRORS']=true; //To see the errors on the web or only in log files
```

## <a name="libraries"></a> Libraries
[top](#top)

Bootils include 2 popular libraries, Kint and Swiftmailer.

### <a name="kint"></a> Kint

Kint is a modern and powerful PHP debugging helper. You can see more about the features and licensing on [Kint Webpage](http://raveren.github.io/kint/)

The most popular functions of KINT, are (`s()`) and (`d()`) used for replace the useless (`var_dump()`) or (`print_r()`)

### <a name="swiftmailer"></a> Swiftmailer

Swiftmailer is a free Feature-rich PHP Mailer. You can see more about the features and licensing on [Swiftmailer Webpage](http://http//swiftmailer.org/)

This library is used in the quick access function (`fastMail()`) if enable it

## <a name="functions"></a> Functions list
[top](#top)

### sortField()
Sort an array based on a specific field
```
$NewArray = sortField($originalArray,'title', true);
```
Array that we want to modify (default null)
Field that will mark the new order (default null)
Do descending order (default false)

### unix2locale()
Converts a unix date to date format in the regional current locales
```
echo unix2locale(1376049980, '%A, %e de %B de %Y');
```
Unix data to convert (default is current time of server)
Format to convert (default format is pre-configured in config.bootis.php)
Output sample:
```
Divendres,  9 d'agost de 2013
```
### now()
Return array of the current datetime in unix, human & object format
```
$currentdate = now();
```
Output sample:
```
array(3) [
    'unix' => integer 1376049980
    'human' => string (29) "Divendres,  9 d'agost de 2013"
    'object' => object DateTime (3) {
        public date -> string (19) "2013-08-09 14:06:20"
        public timezone_type -> integer 3
        public timezone -> string (13) "Europe/Berlin"
    }
]
```

### fastMail()
Send one smtp or phpmail with the same function dependent on the pre-configuration file (config.bootis.php)

#### Simple use
```
$extras['attachment']='./photos/sample_photo.jpg';
fastMail("sample@example.org","my first email","My HTML body",$extras);
```
#### Advanced use
```
/* Configure Senders */

$extras['sender']=array(
    'recipient-with-name@example.org' => 'Recipient Name One',
    'no-name@example.org', // Note that this is not a key-value pair
    'named-recipient@example.org' => 'Recipient Name Two'
);

/* Configure Copy Recipients */

$extras['cc']=array(
    'recipient-with-name@example.org' => 'Recipient Name One',
    'no-name@example.org', // Note that this is not a key-value pair
    'named-recipient@example.org' => 'Recipient Name Two'
);

/* Configure Hiddencopy Recipients */

$extras['bcc']=array(
    'recipient-with-name@example.org' => 'Recipient Name One',
    'no-name@example.org', // Note that this is not a key-value pair
    'named-recipient@example.org' => 'Recipient Name Two'
);

/* Configure the charset of mail */

$extras['charset']='iso-8859-1'; 
$extras['html_charset']='UTF-8'; 
$extras['plain_charset']='iso-8859-1'; 
/* Configure the priority of mail */
//1 greater important than 5 (1 to 5 integer value)
$extras['priority']=2; 

/* Attachment files to email (Works only if swiftmailer is enabled) */

$extras['attachment']=array(
    './photos/sample.jpg',
    './photos/sample2.jpg',
    './photos/sample3.jpg'
);

/* send mail */

fastMail("sample@example.org","my first email","My HTML body",$extras);
```


### checkMail()
Checks that the mail has the correct format
```
if(checkMail("sample@example.org")){
    //your action here if mail is correct;
}else{
    //your action here if mail is incorrect;
}
```
### encodeMail()
Encode an email to that robots can not read
```
echo encodeMail("sample@example.org");
```
Output visible in html code (for robots)
```
&#115;&#97;&#109;&#112;&#108;&#101;&#64;&#101;&#120;&#97;&#109;&#112;&#108;&#101;&#46;&#111;&#114;&#103;
```
Output visible in the web (for humans)
```
sample@example.org
```

### encodeMailString()
Search and encodes emails in a text so that it can be read by robots
```
echo encodeMailString("One or more email address sample@example.org integrated in the text");
```
Output visible in html code (for robots)
```
One or more email address &#115;&#97;&#109;&#112;&#108;&#101;&#64;&#101;&#120;&#97;&#109;&#112;&#108;&#101;&#46;&#111;&#114;&#103; integrated in the text");
```
Output visible in the web (for humans)
```
One or more email address sample@example.org integrated in the text");
```

### getTime()
Returns an array with the last access date, file modification and file changed
```
$array = getTime('./photos/sample.jpg');
```
Output:
```
array(3) [
    'modified' => integer 1376052474
    'accessed' => integer 1376052474
    'changed' => integer 1376052474
]
```

### getPermissions()
Returns an array with three different formats of file permissions (Numeric, Octal and Full)
```
$array = getTime('./photos/sample.jpg');
```
Output:
```
array(3) [
    'numeric' => integer 33188
    'octal' => string (4) "0644"
    'full' => string (10) "-rw-r--r--"
]
```

### dir2array()
Convert in a complet array a selected folder and their subfolders
```
$array = dir2array('./photos/',true);
```
Output:
```
array(3) [
    array(10) [
        'name' => string (10) "sample.jpg"
        'path' => string (7) "photos/"
        'size' => integer 0
        'type' => string (4) "file"
        'node' => integer 10510642
        'group' => integer 1000
        'time' => array(3) [
            'modified' => integer 1376052722
            'accessed' => integer 1376052722
            'changed' => integer 1376052722
        ]
        'perms' => array(3) [
            'numeric' => integer 33188
            'octal' => string (4) "0644"
            'full' => string (10) "-rw-r--r--"
        ]
        'content' => array(4) [
            'base64' => string (0) ""
            'mime' => string (24) "image/jpeg"
            'name' => string (10) "sample.jpg"
            'size' => integer 0
        ]
        'mime' => string (24) "image/jpeg"
    ]
    array(9) [
        'name' => string (9) "subfolder"
        'path' => string (7) "photos/"
        'size' => integer 4096
        'type' => string (3) "dir"
        'node' => integer 10881320
        'group' => integer 1000
        'time' => array(3) [
            'modified' => integer 1376052742
            'accessed' => integer 1376052741
            'changed' => integer 1376052742
        ]
        'perms' => array(3) [
            'numeric' => integer 16877
            'octal' => string (4) "0755"
            'full' => string (10) "drwxr-xr-x"
        ]
        'content' => array(1) [
            array(10) [
                'name' => string (11) "sample3.jpg"
                'path' => string (17) "photos/subfolder/"
                'size' => integer 0
                'type' => string (4) "file"
                'node' => integer 10881321
                'group' => integer 1000
                'time' => array(3) [
                    'modified' => integer 1376052739
                    'accessed' => integer 1376052742
                    'changed' => integer 1376052742
                ]
                'perms' => array(3) [
                    'numeric' => integer 33188
                    'octal' => string (4) "0644"
                    'full' => string (10) "-rw-r--r--"
                ]
                'content' => array(4) [
                    'base64' => string (0) ""
                    'mime' => string (24) "image/jpeg"
                    'name' => string (11) "sample3.jpg"
                    'size' => integer 0
                ]
                'mime' => string (24) "image/jpeg"
            ]
        ]
    ]
    array(10) [
        'name' => string (11) "sample2.jpg"
        'path' => string (7) "photos/"
        'size' => integer 0
        'type' => string (4) "file"
        'node' => integer 10510643
        'group' => integer 1000
        'time' => array(3) [
            'modified' => integer 1376052724
            'accessed' => integer 1376052729
            'changed' => integer 1376052729
        ]
        'perms' => array(3) [
            'numeric' => integer 33188
            'octal' => string (4) "0644"
            'full' => string (10) "-rw-r--r--"
        ]
        'content' => array(4) [
            'base64' => string (0) ""
            'mime' => string (24) "image/jpeg"
            'name' => string (11) "sample2.jpg"
            'size' => integer 0
        ]
        'mime' => string (24) "image/jpeg"
    ]
]
```
If second param is true, include the content of files

### getMime()
Returns the MIME information from a file in string format
```
echo getMime('photo/sample.jpg');
```
Output:
```
image/jpeg
```
### file2base64()
Returns an array with base64 code, mime, name & size of file
```
$array = file2base64('photo/sample.jpg');
```
Output:
```
array(4) [
    'base64' => string (11584) "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"
    'mime' => string (9) "image/png"
    'name' => string (11) "redmine.png"
    'size' => integer 8687
]
```
### getExtension()
Returns the extension of a file in string value
```
echo getExtension('photo/sample.jpeg');
```
Output:
```
jpeg
```
### size2size()
Convert size values (Available formats: B, KB, MB, GB, TB PB, EB, ZB, YB)
```
echo size2size(1024,'GB','KB',2);
```
Output:
```
1.073.741.824,00 kB
```
### fileHash()
Returns the sha1 hash from base64 code of file
```
echo fileHash('photo/sample.jpeg');
```

### getIP()
Returns the user's real IP avoiding proxy in string format
```
echo getIP();
```
Output:
```
84.20.14.219
```

### noCache()
Add php headers for disable cache
```
noCache();
```
### redirect()
add php header location for redirect
```
redirect('http://www.mynewblog.com',true); // true indicate permanent redirection
```

### userLanguage()
Returns an array (neat to priorities) with user languages
```
echo userLanguage();
```
Output:
```
array(3) [
    string (2) "ca"
    string (2) "es"
    string (2) "en"
]
```

### asciQuotes()
Convert ASCI quotes to text format (to clean text, before saving it to the database)
```
$newText = asciQuotes($text);
```

### smartQuotes()
Convert smart quotes to text format (to clean text, before saving it to the database)
```
$newText = smartQuotes($text);
```
### string2url()
Returns the string without spaces or symbols to build friendly URLs
```
$urlFriendly = string2url($title);
```
### cut()
Cut a length of text characters you want, without breaking any word
```
$newText = cut($text, 100, true);
```
if third value is true, returned with an ellipsis at the end of the textOnly if the result has been cut

### checkLink()
Checks whether the link contains protocol, if negative adds it
```
echo checkLink($myLinnk,'ftp://');
```
The default protocol is "http://"

### html2txt()
Converts html to plain text maintaining a human readable format without losing links
```
$mailPlainText= html2txt($bodyHtml);
```
## <a name="included"></a> What's included
[top](#top)

Within the download you'll find the following directories and files, You'll see something like this:

```
bootils/
├── functions/
│   ├── arrays.functions.php
│   ├── date.functions.php
│   ├── email.functions.php
│   ├── files.functions.php
│   ├── server.functions.php
│   └── string.functions.php
│
├── shortcuts/
│   ├── arrays.shortcuts.php
│   ├── date.shortcuts.php
│   ├── email.shortcuts.php
│   ├── files.shortcuts.php
│   ├── server.shortcuts.php
│   └── string.shortcuts.php
│
├── third/
│   ├── kint/ 	(complete library - 146,3 kB)
│   └── swift/  (complete library - 634,9 kB)
│
├── config.bootils.php
└── start.bootils.php
```

## <a name="license"></a> License
[top](#top)

Read the atached [LICENSE](https://github.com/oriolet/bootils/blob/master/LICENSE) file

## <a name="download"></a> Download
[top](#top)

Less than 300 KB
[Download bootils](https://github.com/oriolet/Bootils/archive/master.zip)

