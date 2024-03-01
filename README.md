# AnySpace 
AnySpace is an Open Source Social Network platform similar to MySpace circa 2005-2007, designed with self-hosting in mind. A homage to the golden era of social networking, bringing back the simplicity and charm of early social media platforms with a focus on privacy, user experience, and community 

Designed to be lightweight, user-friendly, and customizable, allowing users to express themselves just like in the old days but with the peace of mind that modern security practices bring.

- **Profiles:** Customizable user profiles with options for background images, music, and integrated layout support.
- **Blogging:** A blogging platform for users to share thoughts, stories, and updates.
- **Messaging:** Private and secure messaging between users.
- **Friends:** Connect with others, manage friendship requests, and explore user profiles.
- **Groups:** Create and join interest-based groups for discussions and events.
- **Customization:** Extensive customization options for user profiles and blogs.

## Prerequisites
- PHP >= 5.3
- MySQL >= 5.0 or compatible database
- Web Server (Apache/Nginx)

## Install

1. Clone repo and transfer files to webserver. Webserver should serve files in `public` directory.
2. Create database and update settings in `config.php` to connect to the database.
3. Set site and domain name in `config.php`
4. Navigate to `http://<DOMAIN-NAME>/install.php` to create the database tables and the admin user.

`pfp` and `music` folders need r/w/x permissions for the webserver user. 

It's recommended to set the following in your `php.ini`

```
file_uploads = On
upload_max_filesize = 10M
post_max_size = 15M
max_execution_time = 60
max_input_time = 120
memory_limit = 128M
```

### Admin Panel
The admin panel should not be made available to the public. The id of the admin user can be set in `config.php`, by
default it is set to user with id 1. Future plans include multi-user access to the admin panel using a permissions
system.  

## Features

- [x] Admin Panel 
- [ ] Authentication
  - [x] Login/Logout
  - [x] Registration
  - [ ] Password Reset
  - [ ] Email Verification
- [x] Blog
- [x] Bulletins
- [x] Comment System
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
- [x] Custom HTML/CSS Profile Layouts

## Screenshot

![screenshot](public/docs/screenshot.png)

## Project Structure

```
project-root/
│
├───admin/                    # Administration tools and dashboards
│
├───core/                     # Core application logic
│   ├───components/           # Shared site components
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
- Database schema will change frequently at this stage of development. If you receive a "PDO exception" you most likely need to create the appropriate  table or column.

## Credits

[MySpace](myspace.com) <br>
[SpaceHey](spacehey.com) <br>
[This spacemy.xyz codebase](https://github.com/Ahe4d/spacemy.xyz) <br>
[Trumbowyg](https://github.com/Alex-D/Trumbowyg)<br>
[@wittenbrock](https://github.com/wittenbrock/toms-myspace-page) 