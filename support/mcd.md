# MCD

reserve, 01 AGENDA, 0N USER
AGENDA: date, time, reservation_date, created_at, updated_at
set, 11 AGENDA, 0N GARAGE
offer, 0N SERVICE, 1N GARAGE
SERVICE: name, price, created_at, updated_at

USER: username, firstname, lastname, phone, adress, avatar, email, role, created_at, updated_at
is, 01 USER, 11 GARAGE
GARAGE: name, adress, phone, email, created_at, updated_at, mobility, distance
has, 0N GARAGE, 11 IMAGE
:

write, 11 COMMENT, 0N USER
COMMENT: content, rate, created_at, enable
dispose, 11 COMMENT, 0N GARAGE
IMAGE: url
: