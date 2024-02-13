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

### CSS Examples

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

