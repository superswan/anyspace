# AnySpace Help

Here you will find support documentation on using the site. 

## Profile Customization

 This will help you personalize the appearance of the page according to your preferences.

### Edit Profile

You can edit your profile from the Home page by selecting 'Edit Profile'.

This page allows users to edit their profile information. It includes options to change username, upload profile picture and song, set bio and interests, and customize layout using CSS.

### Layouts

The "Layouts" feature allows you to customize the appearance of your profile page similar to the "About Me:" section on MySpace. The code pasted in block will loaded into your Bio when your profile is viewied. This includes full layouts as well as blinkies and other page content. 

#### External Layouts

We plan on supporting styles and layouts from other MySpace-like sites in the future (myspace, windows93, spacehey, spacemy.xyz, etc.)

AnySpace is currently compatible with SpaceHey layouts. 

This covers the main sections of the profile page. You can further refine each rule based on your specific design preferences and the layout requirements of your page.

### CSS Cheat Sheet

The following content has been taken from SpaceHey user 𝙙✩𝙣𝙣𝙮
https://blog.spacehey.com/entry?id=1087827

#### Changing background color:

```html
<style>

body {

background color: example color !important;

}

</style>
```

[you can use a color code, eg. #ffffff (white), or just a word, eg. 'white', in the 'example color' section. this applies to all codes.]



#### Changing background image:

```html
<style>

body {

background-image: url("insert link here") !important;

background-color: example color !important;

background-attachment: fixed !important;

margin: 0;

padding: 0;

}

<style>
```



#### inserting an image/gif anywhere:

```html
<img src="insert link here"/>
```


#### changing your cursor:

go to cursors-4u.com, find a cursor you want, find the 'code' section, and copy it into your 'about me' in between two style tags. for example:

```html
<style>

<style type="text/css">* {cursor: url(https://ani.cursors-4u.net/symbols/sym-8/sym761.ani), url(https://ani.cursors-4u.net/symbols/sym-8/sym761.png), auto !important;}</style><a href="https://www.cursors-4u.com/cursor/2014/03/25/sexy-red-lips.html" target="_blank" title="Sexy Red Lips"><img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Sexy Red Lips" style="position:absolute; top: 0px; right: 0px;" /></a>

</style>
```


#### adding a dropdown menu:

```html
<details><summary style="font-size: 13px;" class="mb8"><u>insert title here</u> </summary><p>

example text

</p></details>
```


#### adding a scrollbox:

```html
<div style="width: 400px; height: 120px; background-color: none ; border-color: #black; border-width: 0px; border-style: dotted; color: #000000; font-size: 11px; overflow: auto;"><p> 

example text

</p></div>

```

#### adding another box to your interest section (insert this into your 'heroes' section):

```html
<tr><td>

<p>example title of new section</p>

</td><td>

<p>example content of new section</p>

</td></tr>
```


#### remove box from your interest section:

```html
<style>

.table-section:nth-last-child(2) .details-table tr:nth-child(insert number here){display:none;}

</style>
```


#### rename box/es in your interest section:
```html
<style>

.table-section:nth-last-child(2) .details-table tr:nth-child(insert number here) td:first-child p:before { content:"new name for the interest section"; font-size:.7rem; }

</style>
```

[this subsection is related to the previous two code snippets]

which number to replace the 'insert number here' text with (the numbers change which section you want to rename/remove):

1 - general
2 - music
3 - movies
4 - television
5 - books
6 - heroes



#### change dividers between navigation links:

```html
<style>

nav .links li:not(:last-child)::after, footer .links li:not(:last-child)::after {

  content: " symbol here (recommend a space on either side) ";

  color: insert color;

}

</style>
```


#### changing the link titles in your contact box:

```html
<style>

{font-size:12px}

.contact .inner .f-row:nth-child(1) .f-col:nth-child(1) a:after{content:"text for 'add/remove'"}

.contact .inner .f-row:nth-child(1) .f-col:nth-child(2) a:after{content:"text for 'favorite'"}

.contact .inner .f-row:nth-child(2) .f-col:nth-child(1) a:after{content:"text for 'sent IM'"}

.contact .inner .f-row:nth-child(2) .f-col:nth-child(2) a:after{content:"text for 'forward to friend'"}

.contact .inner .f-row:nth-child(3) .f-col:nth-child(1) a:after{content:"text for 'instant messages'"}

.contact .inner .f-row:nth-child(3) .f-col:nth-child(2) a:after{content:"text for 'block'"}

.contact .inner .f-row:nth-child(4) .f-col:nth-child(1) a:after{content:"text for 'add to group'"}

.contact .inner .f-row:nth-child(4) .f-col:nth-child(2) a:after{content:"text for 'report'"}

</style>
```


#### changing the title of your contact box:

```html
<style>

.contact .heading{ font-size:0; }

.contact .heading:before{ content: "insert contact box title"; font-size:.8rem; font-weight:bold;

</style>
```


#### changing the symbols in your contact box:

```html
<style>

.contact .inner a img {

font-size: 0;

}

.contact .inner a img:before {

font-size: 1em;

display: block

}

.contact .inner .f-row:nth-child(1) .f-col:nth-child(1) a:before {

*add to friends*

content: url("insert link")

}

.contact .inner .f-row:nth-child(1) .f-col:nth-child(2) a:before {

*add to favorites*

content: url("insert link")

}

.contact .inner .f-row:nth-child(2) .f-col:nth-child(1) a:before {

*send message*

content: url("insert link")

}

.contact .inner .f-row:nth-child(2) .f-col:nth-child(2) a:before {

*forward to friend*

content: url("insert link")

}

.contact .inner .f-row:nth-child(3) .f-col:nth-child(1) a:before {

*instant message*

content: url("insert link")

}

.contact .inner .f-row:nth-child(3) .f-col:nth-child(2) a:before {

*block user*

content: url("insert link")

}

.contact .inner .f-row:nth-child(4) .f-col:nth-child(1) a:before {

*add to group*

content: url("insert link")

}

.contact .inner .f-row:nth-child(4) .f-col:nth-child(2) a:before {

*report user*

content: url("insert link")

}

</style>
```


#### removing contact box symbols:

```html
<style>

.contact .inner a img {

font-size: 0;

}

.contact .inner a img:before {

font-size: 1em;

display: block

}

</style>
```


#### rename 'blurbs' title:

```
<style>

  .blurbs .heading{ font-size:0; }

.blurbs .heading:before{ content: "insert title"; font-size:.8rem; font-weight:bold; color:insert color; }

</style>
```

#### change title above your blogs (on your profile):

```
<style>

.blog-preview h4{ font-size:0; }

.blog-preview h4 a{font-size:.8rem;margin-left:5px; }

.blog-preview h4:before{ content: "view [your name]'s blogs:"; font-size:.8rem; }

</style>
```


#### change title of your friendspace (on your profile):

```
<style>

.friends .heading{ font-size:0; }

.friends .heading:before{ content: "[your name]'s friends:"; font-size:.8rem; font-weight:bold; }

</style>
```


#### change title of your comment section (on your profile):

```
<style>

.friends#comments .heading{ font-size:0; }

.friends#comments .heading:before{ content: "[your name]'s profile comments:"; font-size:.8rem; font-weight:bold; }

</style>
```


#### change title of your interests and link sections (on your profile):

```
<style>

 .profile .table-section .heading h4 { font-size:0; }

.profile .table-section .heading h4:before{ content: "[your name]'s interests + links:"; font-size:.8rem; font-weight:bold; 

 </style>
```


#### change logo (on your profile):

```
<style>

.logo{content:url("link to new image here")}

</style>
```


#### adding gifs/images to the corner of your profile:

```
*top right*

<div style="float: ; max-height: 400px; position: fixed; right: 1px; top: 9px; z-index: 200;">

<img src="insert link" width="250" height="250"/></div>

*top left*

<div style="float:  ; max-height: 400px; position: fixed; left: 1px; top: 9px; z-index: 200;">

<img src="insert link" width="250" height="250"/></div>

*bottom right*

<div style="float:  ; max-height: 400px; position: fixed; left: 1px; bottom: 9px; z-index: 200;">

<img src="insert link" width="250" height="250"/></div>

*bottom left*

<div style="float:  ; max-height: 400px; position: fixed; left: 1px; bottom: 9px; z-index: 200;">

<img src="insert link" width="250" height="250"/></div>
```


adding autoplay music to your page **(please avoid doing this and use the built-in audio upload instead)**:

```html:
<iframe width="0" height="0" src="insert link (only works with youtube as far as i know)" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" loading="lazy">
</iframe>
```


#### adding falling gifs/images to your page:

```html
<div class="snowflakes">
  <div class="snowflake">
   <img src="insert image link"/>
  </div>
  <div class="snowflake">
  <img src="insert image link"/>
  </div>
  <div class="snowflake">
  <img src="insert image link"/>
  </div>
  <div class="snowflake">
  <img src="insert image link"/>
  </div>
  <div class="snowflake">
  <img src="insert image link"/>
  </div>
  <div class="snowflake">
  <img src="insert image link"/>
  </div>
  <div class="snowflake">
    <img src="insert image link"/>
  </div>
  <div class="snowflake">
    <img src="insert image link"/>
  </div>
  <div class="snowflake">
     <img src="insert image link"/>
  </div>
  <div class="snowflake">
    <img src="insert image link"/>
  </div>
  <div class="snowflake">
    <img src="insert image link"/>
  </div>
  <div class="snowflake">
    <img src="insert image link"/>
  </div>
</div>

<style>

*customizable snowflake styling*
.snowflake {
  color: insert color;
  font-size: 2em;
  font-family: Arial, sans-serif;
  text-shadow: 0 0 0px rgba(0,0,0,0.7);
}
@-webkit-keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@-webkit-keyframes snowflakes-shake{0%,100%{-webkit-transform:translateX(0);transform:translateX(0)}50%{-webkit-transform:translateX(80px);transform:translateX(80px)}}@keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@keyframes snowflakes-shake{0%,100%{transform:translateX(0)}50%{transform:translateX(80px)}}.snowflake{position:fixed;top:-10%;z-index:9999;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:default;-webkit-animation-name:snowflakes-fall,snowflakes-shake;-webkit-animation-duration:10s,3s;-webkit-animation-timing-function:linear,ease-in-out;-webkit-animation-iteration-count:infinite,infinite;-webkit-animation-play-state:running,running;animation-name:snowflakes-fall,snowflakes-shake;animation-duration:10s,3s;animation-timing-function:linear,ease-in-out;animation-iteration-count:infinite,infinite;animation-play-state:running,running}.snowflake:nth-of-type(0){left:1%;-webkit-animation-delay:0s,0s;animation-delay:0s,0s}.snowflake:nth-of-type(1){left:10%;-webkit-animation-delay:1s,1s;animation-delay:1s,1s}.snowflake:nth-of-type(2){left:20%;-webkit-animation-delay:6s,.5s;animation-delay:6s,.5s}.snowflake:nth-of-type(3){left:30%;-webkit-animation-delay:4s,2s;animation-delay:4s,2s}.snowflake:nth-of-type(4){left:40%;-webkit-animation-delay:2s,2s;animation-delay:2s,2s}.snowflake:nth-of-type(5){left:50%;-webkit-animation-delay:8s,3s;animation-delay:8s,3s}.snowflake:nth-of-type(6){left:60%;-webkit-animation-delay:6s,2s;animation-delay:6s,2s}.snowflake:nth-of-type(7){left:70%;-webkit-animation-delay:2.5s,1s;animation-delay:2.5s,1s}.snowflake:nth-of-type(8){left:80%;-webkit-animation-delay:1s,0s;animation-delay:1s,0s}.snowflake:nth-of-type(9){left:90%;-webkit-animation-delay:3s,1.5s;animation-delay:3s,1.5s}.snowflake:nth-of-type(10){left:25%;-webkit-animation-delay:2s,0s;animation-delay:2s,0s}.snowflake:nth-of-type(11){left:65%;-webkit-animation-delay:4s,2.5s;animation-delay:4s,2.5s}

</style>
```


adding a gif/image overlay:
```
<style>

html:after{ 

   animation: grain 8s steps(10) infinite;

   background-image: url(insert link here);

   background-size: 8%; 

   content: "";

   height: 200%;

   left: -50%;

   opacity: 0.08;

   position: fixed;

   top: -100%;

   width: 200%;

   pointer-events:none}

</style>
```



change base/root colors (for example, the light blue and orange from the default layout):

```html
<style>

   :root {
   --logo-blue: insert color or type 'transparent';
   --darker-blue: insert color or type 'transparent';
   --lighter-blue: insert color or type 'transparent';
   --lightest-blue: insert color or type 'transparent';
   --dark-orange: insert color or type 'transparent';
   --light-orange: insert color or type 'transparent';
   --even-lighter-orange: insert color or type 'transparent';
   --green: insert color or type 'transparent';
     }

</style>
```


change 'online now' icon:

```html
<style>
.online{content:url("insert link");}
</style>
```


adding a background to your contact box:

```html
<style>

   .contact {

  border-radius: 25px;

  background: url(insert image/gif link);

  background-position: left top;

  background-repeat: repeat;

  padding: 0px;

  width: 250px;

  height: 150px;

  color: insert color!important;

}

</style>
```



adding a background to your blurbs: 

```html
<style>

   .blurbs {

  border-radius: 25px;

  background: url(insert image/gif link);

  background-position: left top;

  background-repeat: repeat;

  padding: 0px;

  width: 250px;

  height: 150px;

  color: insert color!important;

}

</style>
```

#### adding a background to you blog preview:

```html
<style>

   .blog-preview {

  border-radius: 25px;

  background: url(insert image/gif link);

  background-position: left top;

  background-repeat: repeat;

  padding: 0px;

  width: 250px;

  height: 150px;

  color: insert color!important;

}

</style>
```


#### adding a background to your interest table:

```html
<style>

   .table {

  border-radius: 25px;

  background: url(insert image/gif link);

  background-position: left top;

  background-repeat: repeat;

  padding: 0px;

  width: 250px;

  height: 150px;

  color: insert color!important;

}

</style>
```


#### changing the little icons on your page (verified checkmark, notification bell, etc.):

```html
<style>

}

.url-info{display:none !important;}

.icon, .award img {

    content: url(insert link);

    display: inline-block;

    height: 2.0em;

    width: 2.0em;

    margin: 0 .05em 0 .1em;

    vertical-align: -0.3em;

    color: rgba(0,0,0,0);

}

</style>
```


#### remove all icons:

```html
<style>

.icon{display:none}

</style>
```


### Layout Examples

Here is a simple example layout

```
body {
  background-color: #FCE4EC; /* Light pink background */
  color: #444; /* Dark grey for contrast */
  font-family: 'Arial', sans-serif;
}

a {
  color: #F06292; /* Bright pink for links */
  text-decoration: none;
}

a:hover {
  color: #EC407A; /* Darker pink on hover */
}

.master-container {
  background-color: #FFFFFF; /* White background */
  box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Soft shadow for depth */
  padding: 20px;
  border-radius: 8px; /* Rounded corners */
}


.main-header {
background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/84cc7b0d-cab1-40df-954d-945642b5146d/dbytxg7-648af875-ec4f-4246-9d1f-2758fa258f5f.gif?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzg0Y2M3YjBkLWNhYjEtNDBkZi05NTRkLTk0NTY0MmI1MTQ2ZFwvZGJ5dHhnNy02NDhhZjg3NS1lYzRmLTQyNDYtOWQxZi0yNzU4ZmEyNThmNWYuZ2lmIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.Q8waAORPq5QSZKzK9YMT_-HG-CTPuGReTlXLxluIilY'); 
  background-size: cover; 
  background-position: center; 
}

.search-bar .topnav a, .navbar ul li a {
  color: #FFFFFF;
}

.search-bar .submit-btn {
  background-color: #F8BBD0; /* Lighter pink for buttons */
  color: #fff;
  border: none;
  padding: 5px 10px;
  border-radius: 5px;
  cursor: pointer;
}

.search-bar .submit-btn:hover {
  background-color: #F06292; /* Bright pink for button hover */
}


.row.profile.user-home .general-about {
  background-color: #FFEBEE; /* Very light pink */
  padding: 10px;
  border-radius: 5px;
}

.row.profile.user-home .profile-pic img {
  border: 5px solid #FFC1E3; /* Soft pink border */
  border-radius: 50%;
}

.row.profile.user-home .details a {
  color: #EC407A; /* Dark pink for emphasis */
}


.indie-box, .specials {
  background-color: #FFEBEE; /* Very light pink background */
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 8px;
}

.specials .heading h4 {
  color: #F06292; /* Bright pink for headings */
}


.blog-preview, .statistics, .new-people {
  background-color: #FFFFFF; /* White background */
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 15px;
}

.statistics .count, .new-people h4 {
  color: #F06292; /* Bright pink for important numbers and headings */
}


footer {
  background-color: #FCE4EC; /* Light pink background */
  color: #444; /* Dark grey for text */
  padding: 20px;
  text-align: center;
}

footer a {
  color: #F06292; /* Bright pink for links */
}

footer a:hover {
  color: #EC407A; /* Darker pink on hover */
}

.navbar {
  background-color: #FFAEC9; /* A different shade of pink for the navbar */
}

.navbar ul li a {
  color: #FFFFFF; /* Keeping text color white for contrast */
}

.navbar ul li a:hover {
  color: #FCE4EC; /* Lighter pink for hover effects */
}
```

#### Screenshot 
![Example Custom CSS](example_layout.png)


### Common Syles


### HTML Document Structure

1. **Root**
   - `<html>`: Root element of the HTML document.
     - `<head>`: Contains meta-information about the document.
     - `<body>`: Contains the visible content of the document.

2. **Containers:**
   - `.container`: Main container for the entire page content.

3. **Header/Navigation:**
   - `<nav>`: Contains navigation links.
     - `.top`: Top navigation bar.
       - `.left`: Left-aligned section of the top bar.
       - `.center`: Center-aligned section of the top bar.
       - `.right`: Right-aligned section of the top bar.
     - `.links`: Additional navigation links.

4. **Main Content:**
   - `<main>`: Main content area of the page.
     - `.row.profile`: Row for the user profile.
       - `.col`: Columns within the profile row.
         - `.w-40`: Left column with a width of 40%.
         - `.left`: Left-aligned content within the left column.
         - `.right`: Right column with additional content.
         - `.general-about`: Section for general information about the user.
         - `.profile-pic`: Container for the profile picture.
         - `.details`: Container for additional details about the user.
         - `.mood`: Section for the user's mood.
         - `.contact`: Section for contacting the user.
         - `.url-info`: Section for displaying the user's AnySpace URL.
         - `.table-section`: Section for displaying the user's interests.
       - `.blog-preview`: Section for displaying the user's latest blog entries.
       - `.friends`: Section for displaying the user's friends and friend-related content.

5. **Footer:**
   - `<footer>`: Footer section of the page.
     - `.links`: Links within the footer.
     - `.copyright`: Copyright information.

This hierarchy outlines the structure of the HTML elements and their respective classes in the page. Each class is used to style specific sections of the page, providing a clear organization of the content.



## BBCode
BBCode can be used in bio and comments in place of HTML (security reasons)

| Example in HTML/CSS | BBCode | Output |
|---------------------|--------|--------|
| `<b>bolded text</b>`, `<strong>bolded text</strong>` or `<span style="font-weight: bold;">bolded text</span>` | `[b]bolded text[/b]` | **bolded text** |
| `<i>italicized text</i>`, `<em>italicized text</em>` or `<span style="font-style: italic;">italicized text</span>` | `[i]italicized text[/i]` | *italicized text* |
| `<ins>underlined text</ins>` or `<span style="text-decoration: underline;">underlined text</span>` | `[u]underlined text[/u]` | <u>underlined text</u> |
| `<del>strikethrough text</del>` or `<span style="text-decoration: line-through;">strikethrough text</span>` | `[s]strikethrough text[/s]` | ~~strikethrough text~~ |
| `<a href="https://en.wikipedia.org">https://en.wikipedia.org</a>`<br/>`<a href="https://en.wikipedia.org">English Wikipedia</a>` | `[url]https://en.wikipedia.org[/url]`<br/>`[url=https://en.wikipedia.org]English Wikipedia[/url]` | [https://en.wikipedia.org](https://en.wikipedia.org)<br/>[English Wikipedia](https://en.wikipedia.org) |
| `<img src="https://upload.wikimedia.org/wikipedia/commons/7/70/Example.png" alt="This is just an example" />` | `[img alt="This is just an example"]https://upload.wikimedia.org/wikipedia/commons/7/70/Example.png[/img]` | ![This is just an example](https://upload.wikimedia.org/wikipedia/commons/7/70/Example.png) |
| `<img src="Smileys/Face-smile.svg" alt=":-)" >` | `:)` or `[:-)]`<br/>(This and other emoticons, depending on the variant. Most BBCodes do not enclose emoticons in square brackets, leading to frequent accidental usage.) | ![:-)](https://upload.wikimedia.org/wikipedia/commons/thumb/7/79/Face-smile.svg/24px-Face-smile.svg.png) |
| `<blockquote><p>quoted text</p></blockquote>`<br/>(Usually implemented in more advanced ways.) | `[quote]quoted text[/quote]`<br/>`[quote="author"]quoted text[/quote]`<br/>(including optional `author`) | > quoted text |
| `<pre>monospaced text</pre>` | `[code]monospaced text[/code]` | `monospaced text` |
| `<span style="font-size:30px">Large Text</span>` or `<span style="font-size:85%">Smaller Text</span>` | `[style size="30px"]Large Text[/style]`<br/>`[style size="85"]Smaller Text[/style]` | **Large Text**<br/>Smaller Text |
| `<span style="color:fuchsia;">Text in fuchsia</span>` or `<span style="color:#FF00FF;">Text in fuchsia</span>` | `[style color="fuchsia"]Text in fuchsia[/style]` or `[style color="#FF00FF"]Text in fuchsia[/style]` or `[color=#FF00FF]Text in fuchsia[/color]` | Text in fuchsia |
| ```<ul><li>Entry A</li><li>Entry B</li></ul><ol><li>Entry 1</li><li>Entry 2</li></ol>``` | ```[list][*]Entry A[*]Entry B[/list][list=1][*]Entry 1[*]Entry 2[/list]``` | - Entry A<br/>- Entry B<br/>1. Entry 1<br/>2. Entry 2 |
| ```<table><tr><td>table cell 1</td><td>table cell 2</td></tr><tr><td>table cell 3</td><td>table cell 4</td></tr></table>``` | ```[table][tr][td]table cell 1[/td][td]table cell 2[/td][/tr][tr][td]table cell 3[/td][td]table cell 4[/td][/tr][/table]``` | | table cell 1 | table cell 2 |<br/>| table cell 3 | table cell 4 |

[Source](view-source:https://en.wikipedia.org/wiki/BBCode)

## Permitted HTML Escaped Characters

