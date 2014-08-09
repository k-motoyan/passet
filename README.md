[![Build Status](https://travis-ci.org/k-motoyan/passet.svg?branch=master)](https://travis-ci.org/k-motoyan/passet)
[![Coverage Status](https://coveralls.io/repos/k-motoyan/passet/badge.png)](https://coveralls.io/r/k-motoyan/passet)

# passet

`passet`はPHPアプリケーションで利用する静的ファイルを管理するためのライブラリです。

## How to install

`composer.json`を書きます。

```json
{
  "require": {
    "passet/passet": "dev-master"
  }
}
```

`composer`からインストールします。  
`php composer.phar install`

## Usage

`passet`の使い方を説明します。

### Output script tags to html

```php
<?php require 'vendor/autoload.php'; ?>

<div>
  <h1>Example</h1>
  <?php \Passet\Manage::js('/path/to/foo.js')->add(); ?>
  <p>......</p>
  <?php \Passet\Manage::js('/path/to/bar.js')->add(); ?>
</div>

<?php \Passet\Manage::outputJs(); ?>
```

出力されるHTMLは以下のようになります。

```html
<div>
  <h1>Example</h1>
  <p>......</p>
</div>

<script src="/path/to/foo.js" type="application/javascript"></script>
<script src="/path/to/bar.js" type="application/javascript"></script>
```

HTMLタグの合間に記載されたコードが、すべて最後の行で出力されます。  
これは、テンプレートファイルを分割して、その中にスクリプトタグが書かれたときに、スクリプトタグがHTMLタグの中に埋もれてしまうのを防ぐ効果があります。

### inline output

スクリプトタグを出力する際に、コードをインライン展開することが可能です。

```js
// this file name is inline.js
console.log('hello world!!');
```

```php
<?php require 'vendor/autoload.php'; ?>
<?php \Passet\Manage::js('inline.js')->writeInline()->add(); ?>
<?php \Passet\Manage::outputJs(); ?>
```

以下のようにjavascriptのコードがインラインで展開されます。

```html
<script type="application/javascript">
// this file name is inline.js
console.log('hello world!!');
</script>
```

普段、インラインで記述するような簡単なコードでも使い回すことが可能になります。

### Output style tags to html

scriptタグ同様にstyleタグを出力することが可能です。

```php
<?php require 'vendor/autoload.php'; ?>

<?php \Passet\Manage::css('/path/to/css')->add(); ?>
<?php \Passet\Manage::css('/path/to/css')->writeInline()->add(); ?>
<?php \Passet\Manage::outputCss(); ?>
```
### Output img tag to html

imgタグはscriptタグやstyleタグのようにまとめと出力する機能はありません。  
imgタグはインラインで読み込むかsrcパスを指定して読み込むかを指定して出力することが可能です。

```php
<?php require 'vendor/autoload.php'; ?>

<?php \Passet\Manage::img('/path/to/img')->build(); ?>
<?php \Passet\Manage::css('/path/to/img')->writeInline()->build(); ?>
```

出力出来るimageファイルは以下のタイプのものに限定されています。  

- png
- jpeg
- gif
- bmp