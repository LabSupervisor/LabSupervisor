# 👀 LabSupervisor

LabSupervisor is designed for education professionals, especially teachers, to enable them to monitor student work in real time. The aim is to set up discreet tracking, as well as visual monitoring of the current session.

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

*To add a new langage, simply create a new file in `lang/` using existing file content with the corresponding translation.*

## 🤔 Requirements

- [Apache2](https://httpd.apache.org/) Latest
- [PHP](https://www.php.net/) ^=8.1
- [NodeJS](https://nodejs.org/) Latest
- [MariaDB](https://mariadb.org/) Latest

## ⚙️ Installation

1. Database

Execute `sql/database.sql` on your database server

2. Modules

`
composer install
`

3. Screenshare server

`
cd server/ && node server.js
`

## 🚧 Administration

- Error logs

Potentials error's logs are store in `log/[current-date].log`, can be display with an admin account on `https://[domain]/logs?error`

- Trace logs

Usage's logs are store in database, can be display with an admin account on `https://[domain]/logs?trace`
