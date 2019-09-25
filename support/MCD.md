# MCD

write, 11 COMMENT, 0N USER
USER: username, firstname, lastname, phone, adress, avatar, email, role, created_at, updated_at
reserve, 01 VISIT, 0N USER
VISIT: date, time, reservation_date, created_at, updated_at
contain, 01 VISIT, 0N SERVICE

COMMENT: content, rate, created_at, enable
dispose, 11 COMMENT, 0N GARAGE
is, 01 USER, 11 GARAGE
set, 11 VISIT, 0N GARAGE
SERVICE: name, price, created_at, updated_at

IMAGE: url
has, 0N GARAGE, 11 IMAGE
GARAGE: name, adress, phone, email, created_at, updated_at, mobility, distance
offer, 0N SERVICE, 1N GARAGE
: