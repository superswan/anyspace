# AnySpace 
AnySpace is an Open Source Social Network similar to MySpace circa 2005 

## Install

1. Clone repo and transfer files to webserver. Webserver should serve files in `public` directory.
2. Create database and update settings in `config.php`
3. Set site and domain name in `config.php`
4. Navigate to `http://<DOMAIN-NAME>/install.php`

`pfp` and `music` folders need r/w/x permissions for the webserver 

It's recommended to set the following in your `php.ini`

```
file_uploads = On
upload_max_filesize = 10M
post_max_size = 15M
max_execution_time = 60
max_input_time = 120
memory_limit = 128M
```

## Features

- [x] Admin Panel 
- [ ] Authentication
  - [x] Login/Logout
  - [x] Registration
  - [ ] Password Reset
  - [ ] Email Verification
- [ ] Blog
  - [x] Posting/Editing
  - [x] Comments
  - [ ] Categories
- [x] Bulletins
- [x] Comment System
  - [ ] Comment replies
- [x] Favorite Users
- [ ] Forum
- [x] Friend System
- [ ] Group System
- [ ] Layout sharing feature
- [ ] Private Messaging
- [ ] Report System
- [ ] Session Management
- [x] User Browser
- [x] User Search
- [x] User Profiles
  - [x] Profile Editing 
  - [x] Custom CSS 

## Screenshot

![screenshot](public/docs/screenshot.png)

## Project Structure

```
project-root/
│
├───core/                     # Core application logic
│   ├───site/                 # Site-specific functionality
│   └───tools/                # Tools and utilities
│
├───lib/                      # Libraries and dependencies
│
└───public/                   # Publicly accessible files
    │
    ├───blog/                 # Blog related files
    │   └───editor/           # Trumbowyg WYSIWIG editor components
    │       ├───langs/        # Language files for Trumbowyg
    │       └───plugins/      # Plugins for Trumbowyg
    │
    ├───bulletins/             # Bulletins related files
    ├───docs/                  # Documentation files
    ├───forum/                 # Forum related files
    ├───groups/                # Groups related files
    ├───layouts/               # Layout related files
    ├───media/                 # User uploaded media files
    │   ├───music/             # Music files
    │   └───pfp/               # Profile picture files
    │
    └───static/                # Static assets
        ├───css/               # CSS files
        ├───icons/             # Icon files
        └───img/               # Image files
```

## Quirks
- Developed with PHP 5.3 compatibility in mind due to limitations of developer hardware
- Bad code parsing for user inputted fields
- CSS

## Credits

[MySpace](myspace.com)
[SpaceHey](spacehey.com)
[This spacemy.xyz codebase](https://github.com/Ahe4d/spacemy.xyz)
[Trumbowyg](https://github.com/Alex-D/Trumbowyg)