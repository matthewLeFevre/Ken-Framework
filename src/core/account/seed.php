<?php

function seedAccounts() {


  $seed = ' [
        {
            "name": {
                "title": "Mrs",
                "first": "Courtney",
                "last": "Price"
            },
            "email": "courtney.price@example.com",
            "login": {
                "uuid": "3b73109d-b7e2-41a1-a7bf-eed54bfb48de",
                "username": "whitetiger913",
                "password": "phish1",
                "salt": "C6heOfNE",
                "md5": "bb0949f02471b844c44a6b78ea037808",
                "sha1": "a82fc69852cd1dd13a6177fcc55a1f5e8fef3576",
                "sha256": "2e39bc7cb09cc003de72755d0390a6538e287f0b1890a83ec25c5ff8289f57f0"
            },
            "registered": {
                "date": "2008-01-17T08:58:00.837Z",
                "age": 11
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Ross",
                "last": "Fernandez"
            },
            "email": "ross.fernandez@example.com",
            "login": {
                "uuid": "78f903bd-ed06-4e47-8a5c-421d33587b36",
                "username": "blackostrich292",
                "password": "rage",
                "salt": "xNTMZQBL",
                "md5": "658e679255120ea4796831513ed15b12",
                "sha1": "aa289964b76ba56373a5957d4c1c1881f5b6cd7f",
                "sha256": "1e63753648edf0ddfafbc231d3a92e2e8631f73ad2515a49d14e83d46b983668"
            },
            "registered": {
                "date": "2016-12-12T17:37:16.143Z",
                "age": 3
            }
        },
        {
            "name": {
                "title": "Mrs",
                "first": "Tamara",
                "last": "Wells"
            },
            "email": "tamara.wells@example.com",
            "login": {
                "uuid": "9da79b2a-31dd-450b-9450-ab80b7a6b5a1",
                "username": "sadduck496",
                "password": "delaney",
                "salt": "p87yXv35",
                "md5": "fd7267760d1107b6b7ef8bc1a7650673",
                "sha1": "15b2d09b036a20529533fed4773c89c84b847e36",
                "sha256": "e87e3513d095feccb1f2fc96f70e70d86936d2f4ab82b962e9c718a814478669"
            },
            "registered": {
                "date": "2015-06-01T09:05:28.969Z",
                "age": 4
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Howard",
                "last": "Schmidt"
            },
            "email": "howard.schmidt@example.com",
            "login": {
                "uuid": "b84bb41b-4aef-4a4b-a3f3-3fe6c5ee4b37",
                "username": "lazygorilla656",
                "password": "swordfis",
                "salt": "bDlYihXE",
                "md5": "1044631c2436c7848e1484402d75f216",
                "sha1": "621cca9f923384951af05b3429fdbc3c575fd6ea",
                "sha256": "f1211b97e611b450bd984824278142b091f110c7d41f6cf1c4409141456c3256"
            },
            "registered": {
                "date": "2005-06-23T00:22:18.462Z",
                "age": 14
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Herbert",
                "last": "Russell"
            },
            "email": "herbert.russell@example.com",
            "login": {
                "uuid": "1ea68394-a0f2-4c3c-a00a-800891365ab3",
                "username": "redfish801",
                "password": "cartoon",
                "salt": "f384wsFt",
                "md5": "7c4f76d20e7243e3523945934bc91655",
                "sha1": "e8744b483fc5dec407208c598e80e621805c0133",
                "sha256": "6afd91ec167d3bba392906e8d665af13bef7bd481f5ba716b994e32f39c55cf1"
            },
            "registered": {
                "date": "2019-02-27T21:43:05.147Z",
                "age": 0
            }
        },
        {
            "name": {
                "title": "Ms",
                "first": "Elsie",
                "last": "Smith"
            },
            "email": "elsie.smith@example.com",
            "login": {
                "uuid": "d74b6d90-72d2-42c7-a769-a22c34ee007b",
                "username": "angrydog165",
                "password": "741852",
                "salt": "BvB4ZIzv",
                "md5": "5a0142e18f82f4a306b79a12142e7044",
                "sha1": "41918e5a4967d50cf9601152d0f0f1e73a92cfbd",
                "sha256": "98833c1c076def3b7560719fcc86ebec581fedabfdae258a00bf6ca203ddd3a9"
            },
            "registered": {
                "date": "2018-08-03T22:44:22.425Z",
                "age": 1
            }
        },
        {
            "name": {
                "title": "Ms",
                "first": "Maureen",
                "last": "Cunningham"
            },
            "email": "maureen.cunningham@example.com",
            "login": {
                "uuid": "7c876c06-833b-4e21-84e4-56c7a06421ef",
                "username": "yellowrabbit907",
                "password": "gareth",
                "salt": "zuttXtWL",
                "md5": "64caba46decd147b3d71960bb23a2318",
                "sha1": "98b57f65b592f53823ff53947f24c8f8f1ba0978",
                "sha256": "c494f40bdbb15a5ead774e2bea3399a0939e92c0418bbb62ef9dafa7a2cec7d5"
            },
            "registered": {
                "date": "2004-05-27T05:41:14.822Z",
                "age": 15
            }
        },
        {
            "name": {
                "title": "Miss",
                "first": "Louise",
                "last": "Ortiz"
            },
            "email": "louise.ortiz@example.com",
            "login": {
                "uuid": "4853a4cb-fb7f-432a-b075-9308706bc862",
                "username": "bluefrog271",
                "password": "sabrina1",
                "salt": "wdQBVnYE",
                "md5": "33025e3da7d94ebf685e22807d9e6c98",
                "sha1": "232384cf6d2b3b323b4ec58f90b69c892a613a5a",
                "sha256": "201360dbf5a930709daa32315b8869c4f2589445009cc445ac8cb58d5cfe7bfb"
            },
            "registered": {
                "date": "2013-04-06T02:31:27.162Z",
                "age": 6
            }
        },
        {
            "name": {
                "title": "Miss",
                "first": "Peyton",
                "last": "Ramos"
            },
            "email": "peyton.ramos@example.com",
            "login": {
                "uuid": "9413025b-4dee-411b-aa75-7ed8650021ee",
                "username": "redleopard801",
                "password": "alfredo",
                "salt": "7jBxxHiy",
                "md5": "f1c5b041b2204affe9f75849ab4162b2",
                "sha1": "dd2467981c3f2446484d893950a324ff77791282",
                "sha256": "63f1bcfdf6959d9f338cd1dccb827d6e25a6189fba59c414292270c43b993f36"
            },
            "registered": {
                "date": "2009-03-13T13:59:44.979Z",
                "age": 10
            }
        },
        {
            "name": {
                "title": "Miss",
                "first": "Brooklyn",
                "last": "Woods"
            },
            "email": "brooklyn.woods@example.com",
            "login": {
                "uuid": "3bf2cf0f-9ea5-438a-9f0b-d7e8ebdb178a",
                "username": "crazybird884",
                "password": "getsdown",
                "salt": "gIhx067S",
                "md5": "b331e31271e436e7b6a39cd2132e8cc7",
                "sha1": "1cae3686cf2529c774717e5e4c3b629730277ed1",
                "sha256": "950441656644f52d581234ac0c78c5d217b4e307c78342270b6b691b42131e60"
            },
            "registered": {
                "date": "2005-09-24T21:44:29.414Z",
                "age": 14
            }
        },
        {
            "name": {
                "title": "Ms",
                "first": "Erin",
                "last": "Willis"
            },
            "email": "erin.willis@example.com",
            "login": {
                "uuid": "189d5465-45c4-4c96-bce1-1a280c1c1212",
                "username": "whitemeercat256",
                "password": "telefon",
                "salt": "omsBPEgR",
                "md5": "0ca4d9fd1d1e4f53d256395e64b8e0d7",
                "sha1": "f7d616d0fc72a9a9c4536cf6d2ba9308708a02ec",
                "sha256": "75fdbe88a1faeeb9c0a1787ff7b3fb7985e0eff30efa129ec0cec578fc7a3358"
            },
            "registered": {
                "date": "2005-02-20T14:24:20.438Z",
                "age": 14
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Charles",
                "last": "Ruiz"
            },
            "email": "charles.ruiz@example.com",
            "login": {
                "uuid": "8a11b796-798f-4b3b-ad0b-9a130553450a",
                "username": "blackfish148",
                "password": "sluttey",
                "salt": "EutHcQCk",
                "md5": "187e84ad4fdcd3a0f1a5e42f136be5ec",
                "sha1": "e177121fd20f8a521514e557c3c17b3ab61a172f",
                "sha256": "e99670b7ffbfd0dcbc8b517c1b28bf3ab6890d5f6aa0b85835aab42301efe834"
            },
            "registered": {
                "date": "2009-05-31T10:28:26.906Z",
                "age": 10
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Same",
                "last": "Adams"
            },
            "email": "same.adams@example.com",
            "login": {
                "uuid": "3d7c3538-a327-40ff-bee8-8d7325a42a51",
                "username": "brownostrich922",
                "password": "saleen",
                "salt": "qUrlPvKC",
                "md5": "ede37055e1d59b2b218f9e7edd3e9b04",
                "sha1": "646562bc016552aae3ea79423b5fbfd97d49a88c",
                "sha256": "b2f78fce13cfc9b67e17972aa6ec932c17276bea0988ee64c77d79fa93d24d77"
            },
            "registered": {
                "date": "2004-09-30T00:30:14.547Z",
                "age": 15
            }
        },
        {
            "name": {
                "title": "Miss",
                "first": "Rita",
                "last": "Hicks"
            },
            "email": "rita.hicks@example.com",
            "login": {
                "uuid": "0b201c9e-cb34-4c0b-a1f2-6668261a8ca6",
                "username": "orangemeercat940",
                "password": "monsters",
                "salt": "1J7onToN",
                "md5": "207f7865ad14b8fee08b1edcf5f122eb",
                "sha1": "e43446cb1ce5934b56576e012370e4e91d346141",
                "sha256": "e71adf9eaf63639e42f0fbbd4f065615d8ab5428bc2e989da7a9fcad2e2656b9"
            },
            "registered": {
                "date": "2006-06-21T11:42:22.997Z",
                "age": 13
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Eduardo",
                "last": "Mason"
            },
            "email": "eduardo.mason@example.com",
            "login": {
                "uuid": "4e4cbc78-40fb-4d2c-ada1-23332da70fa2",
                "username": "beautifulwolf420",
                "password": "flyfish",
                "salt": "3ntG7nle",
                "md5": "45ee94dc18a0a8eeff5592f777b81c27",
                "sha1": "1d921e2ab627fa148cdf934a0f312a0c80dc830d",
                "sha256": "bda5c7e5fe670b63dfc8cf331b8af3e2d69da877be0fef72d30a2747b86dabdf"
            },
            "registered": {
                "date": "2014-05-12T19:35:21.538Z",
                "age": 5
            }
        },
        {
            "name": {
                "title": "Ms",
                "first": "Joanne",
                "last": "Stevens"
            },
            "email": "joanne.stevens@example.com",
            "login": {
                "uuid": "bbab5618-16fe-4fb6-80d4-35a92c1b20b0",
                "username": "crazyladybug921",
                "password": "passme",
                "salt": "QJS7TfCB",
                "md5": "ef26e0519eca4fd546c6ecaa55811e20",
                "sha1": "6dc90c5cf506a333233fcf75e0d425cb4c05bc53",
                "sha256": "17241126d287fb55f0167657b8fd2852e7fb7b16854e03bdf23269764de4dcf9"
            },
            "registered": {
                "date": "2014-11-04T11:13:46.986Z",
                "age": 5
            }
        },
        {
            "name": {
                "title": "Miss",
                "first": "Ida",
                "last": "Banks"
            },
            "email": "ida.banks@example.com",
            "login": {
                "uuid": "9a155133-f9ac-467f-8a88-5ff0ea31f334",
                "username": "smallostrich265",
                "password": "huang",
                "salt": "DB76ceAY",
                "md5": "f9bc35ad7e8424a231bc8dfbc6fb181f",
                "sha1": "057670b5166c0a9a33a3c475e66ae8d0a115a391",
                "sha256": "a19fd6525683474c68b69586f08074cea3a81416e4bdbcd395045ef19e188719"
            },
            "registered": {
                "date": "2005-09-24T23:17:01.519Z",
                "age": 14
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Tim",
                "last": "Harper"
            },
            "email": "tim.harper@example.com",
            "login": {
                "uuid": "71bee92a-2ac9-4032-aca2-db574cb92b6c",
                "username": "orangegorilla871",
                "password": "teddy",
                "salt": "pRQVSkUk",
                "md5": "4656f772eb0dd3edfe6c9e831d18fd19",
                "sha1": "7346e7bd1878d228840ab3f51533530195aa3099",
                "sha256": "b3f6cb5c4a90a5aab03e2c1390d27bf6ef482fa7a3dfb6cb9eaadc2295b7cdd2"
            },
            "registered": {
                "date": "2012-01-13T02:54:34.984Z",
                "age": 7
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Jamie",
                "last": "Mason"
            },
            "email": "jamie.mason@example.com",
            "login": {
                "uuid": "abc8bed6-2c50-4d95-b754-80b72d240460",
                "username": "happyostrich843",
                "password": "trains",
                "salt": "KyO6r9xH",
                "md5": "10ebc504e9d66f4dc51684f760ccc046",
                "sha1": "d145718ba2f0b566fe5eded820a1a5754394161b",
                "sha256": "3dd7b9d61c59bb7a4c9efb4e0d68094514470a14d4ec9b54386d00c8046d1a82"
            },
            "registered": {
                "date": "2018-09-03T02:07:35.874Z",
                "age": 1
            }
        },
        {
            "name": {
                "title": "Mr",
                "first": "Carter",
                "last": "King"
            },
            "email": "carter.king@example.com",
            "login": {
                "uuid": "7702368c-05f8-42de-9234-50e93bb176d0",
                "username": "organicdog506",
                "password": "catcat",
                "salt": "FFPb4WjU",
                "md5": "42da83de8e3c06489859119c1d750a85",
                "sha1": "9f9d93d9c125e529e9bf0c123516a60131950e3e",
                "sha256": "dcedfe372a212819cffbbe2aa044b8853d4e27b210f40fb05d2be4444d6c30b4"
            },
            "registered": {
                "date": "2016-03-24T21:09:40.300Z",
                "age": 3
            }
        }
    ]';

  $decoded = json_decode($seed, true);

  foreach($decoded as $user) {
      $data = [
          "account_name" => $user['name']['first'] . " " . $user['name']['last'],
          "email_address" => $user['email'],
          "pass_hash" => $user['login']['password'],
          "account_created" => $user['registered']['date']
      ];
      AccountModel::seed($data);
  }
}