# Very simple Thesaurus

Can run as php web server or on a apache2 server

### Installation

```sh
$ git clone https://github.com/IvanLarsson/simpleThesaurus.git
```

Database create file and sample data is in 
```sh
$ cd api/_scripts/database
```

Run php web server 

```sh
$ cd api
$ php -S localhost:8091
```

### Test run API
Test scripts are in depending on if api is run as php web server or on a apache server. One folder for php server and one for apache server
```sh
$ cd api/_scripts/test
```

To add synonyms (edit script to change data, there are samle data)
```sh
$ ./addSynonyms.sh
```
To get synonyms depening on a word 
```sh
$ ./getSynonym.sh {word}
```
To get all words in the database 
```sh
$ ./getAllWords.sh 
```

### Todos

 - Add more endpoints 
 - Dockerize application




