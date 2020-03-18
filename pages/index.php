<?php if (!defined('APP_PATH')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="x-dns-prefetch-control" content="on">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="keywords" content="<?php echo $this->variables['options']['keywords']['value']; ?>">
<meta name="description" content="<?php echo $this->variables['options']['description']['value']; ?>">
<title><?php echo $this->variables['options']['title']['value']; ?></title>
<link rel="icon" href="favicon.ico">
<style>
html{line-height:1.15;-webkit-text-size-adjust:100%}
body{margin:0}
main{display:block}
hr{overflow:visible;box-sizing:content-box;height:0}
a{background-color:transparent}
abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}
b,strong{font-weight:bolder}
pre,code,kbd,samp{font-size:1em;font-family:monospace,monospace}
small{font-size:80%}
sub,sup{position:relative;vertical-align:baseline;font-size:75%;line-height:0}
sub{bottom:-.25em}
sup{top:-.5em}
img{border-style:none}
button,input,optgroup,select,textarea{margin:0;font-size:100%;font-family:inherit;line-height:1.15}
button,input{overflow:visible}
button,select{text-transform:none}
[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}
[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}
[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}
fieldset{padding:.35em .75em .625em}
legend{display:table;box-sizing:border-box;padding:0;max-width:100%;color:inherit;white-space:normal}
progress{vertical-align:baseline}
textarea{overflow:auto}
[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}
[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}
[type=search]{outline-offset:-2px;-webkit-appearance:textfield}
[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}
::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}
details{display:block}
summary{display:list-item}
template{display:none}
[hidden]{display:none}
*,:after,:before{-webkit-box-sizing:border-box;box-sizing:border-box}
html{font-size:20px;line-height:1.5;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}
body{overflow-x:hidden;background:#fff;color:#303133;font-size:.7rem;font-family:Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,SimSun,sans-serif;text-rendering:geometricPrecision;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
body,html{height:100%}
#app{height:100%}
h1{font-size:1.8rem}
h2{font-size:1.6rem}
h3{font-size:1.4rem}
h4{font-size:1.2rem}
h5{font-size:1rem}
h6{font-size:.8rem}
h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5em;font-weight:400;line-height:1.2}
abbr[title]{border-bottom:.05rem dotted;text-decoration:none;cursor:help}
ins,u{border-bottom:.05em solid;text-decoration:none}
blockquote{margin-right:0;margin-left:0;padding:.2rem .8rem;border-left:.15rem solid #eee}
code,kbd,pre,samp{font-size:1em;font-family:inherit}
code,kbd,mark{padding:.175rem .25rem;border-radius:4px}
kbd{background:#333;color:#fff}
mark{background:#ffe9b3;color:#333}
code{background:#eee;color:#333}
pre{position:relative;-webkit-overflow-scrolling:touch}
pre code{display:block;overflow-x:auto;margin:0;padding:1rem;background:#eee;line-height:1.5}
pre::before{position:absolute;top:.1rem;right:.4rem;color:#909399;content:attr(data-language);font-size:.5rem;font-family:inherit}
.container{display:flex;box-sizing:border-box;height:100%;min-width:0;flex-direction:row;flex:1;flex-basis:auto}
.container.is-vertical{flex-direction:column}
.footer,.header{padding:0 20px;height:60px;line-height:60px;flex-shrink:0}
.main{display:block;padding:20px;flex:1;flex-basis:auto}
</style>
</head>
<body>
    <div id="app">
        <section class="container is-vertical">
            <header class="header"></header>
            <main class="main" style="text-align:center">
                <h1>你好,世界</h1>
                <p><?php echo $this->variables['options']['title']['value']; ?></p>
            </main>
            <footer class="footer"></footer>
        </section>
    </div>
</body>
</html>
