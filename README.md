# Aplikace RestExample
Jednoduchá aplikace implementující REST API.

## Spuštění testů
Testy je možné spustit zadáním následujícího příkazu v root adresáři projektu: 

`phpunit --colors=auto --bootstrap autoloader.php tests/`

## Nastavení projektu

- vytvořte MySQL databázi nebo použijte stávající
- vytvořte tabulku uživatelů za použití následujících SQL příkazů:

```sql
CREATE TABLE `user_resources` (
  `id_user` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

ALTER TABLE `user_resources`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `user_resources`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
```

- v souboru config/config.json upravte údaje pro připojení k databázi z prvního kroku

## Popis API

### Návratové kódy

- 200: požadavek byl úspěšně zpracován
- 201: vytvoření záznamu bylo úspěšně zpracováno
- 404: neexistující záznam
- 405: nepodporovaná metoada
- 500: neznámá chyba při zpracování požadavku

### Formát dat

Operace POST a PUT očekávají data ve formátu JSON s následující strukturou:

```json
{
  "firstname":"string",
  "surname":"string"
}
```

Operace POST, PUT a GET vrací data ve formátu:

```json
{
  "identifier":int,
  "firstname":"string",
  "surname":"string"
}
```

Operace DELETE vrací data ve formátu:

```json
{
  "identifier":int  
}
```

### Vložení uživatele

- metoda: POST
- URL: `<doména>/user`
- příklad: `curl -XPOST -d '{"firstname":"David","surname":"Dusek"}' http://rest-example.local/user`
- návratový kód (úspěch): 201

### Editace uživatele

- metoda: PUT
- URL: `<doména>/user/{identifier}` kde identifier je identifikátor uživatele
- příklad: `url -XPUT -d '{"firstname":"David","surname":"Dusek"}' http://rest-example.local/user/1`
- návratový kód (úspěch): 200

### Získání detailu uživatele

- metoda: GET
- URL: `<doména>/user/{identifier}` kde identifier je identifikátor uživatele
- příklad: `curl -XGET http://rest-example.local/user/1`
- návratový kód (úspěch): 200

### Smazání uživatele

- metoda: DELETE
- URL: `<doména>/user/{identifier}` kde identifier je identifikátor uživatele
- příklad: `curl -XDELETE http://rest-example.local/user/1`
- návratový kód (úspěch): 200


## TODO

- komplexnější testy třídy Controller
- testy třídy Application
- testy třídy HTTP Response
- detekce neexistujícího resource u metod PUT a DELETE
- todo v kódu
