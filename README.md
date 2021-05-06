# catinal

## Database:
- users
    - username -> VARCHAR(20)
    - password -> VARCHAR(20)
    - lastmoney -> DATE
    - userid -> INT(50) not null auto_increment primary key
    - money -> INT(50)
- cats
    - name -> VARCHAR(20)
    - hunger -> INT(2)
    - age -> INT(2)
    - happiness -> INT(2)
    - lastpet -> DATE
    - rarity -> INT(8)
    - ownerid -> INT(50)

## Todo:
- color cat based on 'rarity' seed
- say amount of earned money
- cat animations
- cat eye movement on login screen

## Daily changes:
- cat hunger descreases by 1
- cat happiness decreases by 1
- cat age increases by 1
- user money increases by 3 (only if you login each day)
- you can pet your cat once per day
