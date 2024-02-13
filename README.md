# AnySpace 
AnySpace is an Open Source Social Network similar to MySpace circa 2005 

## Install

1. Clone repo and transfer files to webserver
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

- [ ] Authentication
  - [x] Login/Logout
  - [x] Registration
  - [ ] Password Reset
  - [ ] Email Verification
- [ ] Blog
  - [x] Posting/Editing
  - [x] Comments
  - [ ] Categories
- [ ] Bulletins
- [x] Comment System
- [ ] Forum
- [x] Friend System
- [ ] Group System
- [ ] Private Messaging
- [ ] Report System
- [x] User Browser
- [x] User Search
- [x] User Profiles
  - [x] Profile Editing 
  - [x] Custom CSS (untested)

## Screenshot

![screenshot](docs/screenshot.png)


