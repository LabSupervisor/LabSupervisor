# 👀 LabSupervisor

> [!NOTE]
> LabSupervisor is designed for education professionals, especially teachers, to enable them to monitor student work in real time. The aim is to set up discreet tracking, as well as visual monitoring of the current session.

## 📝 Table of contents

- [Features](#-features)
	- Account system
	- Role system
	- Multi-langage
- [Requirements](#-requirements)
- [Account connection](#-account-connection)
- [Installation](#-installation)
	- Database
	- Modules
	- Parameters
	- Screenshare server
- [Environment development datas](#-environment-development-datas)
- [Administration](#-administration)
	- Error logs
	- Trace logs

## 👾 Features

- 🙂 Account system

Student and teacher can create account with securised datas.

- 👤 Role system

Three roles are available:

1. Student: Default role,
2. Teacher: Role that provide session creation,
3. Admin: A full access role to manage the application

- 🔗 Multi-langage

On account settings, langage can be changed. Default is french.

Available langage:

- French
- English
- Deutsch
- Spanish
- Italian
- Japan
- Chinese
- Netherlands
- Russian

*To add a new langage, simply create a new file in `lang/` using existing file content with the corresponding translation.*

## 🤔 Requirements

- [Apache2](https://httpd.apache.org/) Latest
- [PHP](https://www.php.net/) ^=8.1
- [NodeJS](https://nodejs.org/) Latest
- [MariaDB](https://mariadb.org/) Latest
- [Composer](https://getcomposer.org/) Latest

## 🔗 Account connection

To connect with an existing account, use their email address and password.

## ⚙️ Installation

1. <u>Database</u>

	- Execute `sql/database.sql` on your database server

	- Execute `sql/data.sql` on your database server

2. <u>Modules</u>

> [!WARNING]
> Make sure to have the [correct PHP version](#-requirements).

Use `composer install` on a terminal open in project's root folder.

3. <u>Parameters</u>

Rename `.env.example` to `.env` <u>and fill credentials</u>.

4. <u>Screenshare server</u>

Execute `cd server/ && node server.js` on a terminal open in project's root folder.

## 📌 Environment development datas

> [!CAUTION]
> Those datas are only for testing purpose, do not commit them on production server.

`sql/data_dev.sql` provide test data set with 150 users and situation.

The account's password are their name in lowercase without any special characters.

```
Example:
	Name: Jérome
	Surname Bélier
	Email: jerome.belier@gmail.com
	Password: jerome
```

## 🚧 Administration

- Error logs

Potentials error's logs are store in `log/[current-date].log`, can be display with an admin account on `https://[domain]/logs?error`

- Trace logs

Usage's logs are store in database, can be display with an admin account on `https://[domain]/logs?trace`
