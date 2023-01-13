# MD Blog dokumentáció

Az MD Blog egy weboldal alapú blog portál. 
Az oldalnak a backend részéhez egy REST API alkalmazást készítettem ami JSON formátumban kommunikál. A kódot php nyelven írtam, és mysql-t használ az adatbázis tárolására. 
A frontend részét html-php nyelven írtam, ami mellett Bootstrap és jQuery keretrendszereket használtam.
Letöltéskor a backend/session_url.php-ban az elérési utat bekell álítani!<br>
Leírás <a href="backend/info.txt" target="_blank">itt</a> található txt-ben. ./backend/info.txt

# Weboldal felépítése:

A weboldal két fő részre van osztva.
• Blog Portal – index.php
• Blog – blog.php?usernameCode
Blog Portál: Ez az felület az összes blogot és felhasználót összefogja. Itt betudunk jelentkezni, az összes blogról és felhasználóról tudhatunk meg információkat.
Blog oldal: Itt minden Blognot külön url címen tudunk elérni. Ez azért jó, mert a kedvelt blogjainkat egyből eltudjuk érni egy linkel. Nem kell külön a Portál oldalra menni és onnan elérni a tartalmat.

# MySQL szerkezet: a bacend / info.txt-ben szépen olvashatóak az információk.

| users         | blogbody      | blogentries       | blogcomments  |
| ------------- |:-------------:|:-----------------:|:-------------:|
|id 			|blogid		    |entrieid           |commentid      |
|username		|userid			|blogid             |userid         |
|useremail		|blogname		|entrietitle	    |entrieid       |
|userpassword	|blogtitle		|entriebody			|commenttext    |
|userrank		|categoryid		|entrieepoch		|commentepoch   |
|userinfo		|startepoch		|		            |               |
|imglink	    |bgimg			|		            |               |

# REST API Endpoints:

## USERS
| Query | Method | Token? | What is it doing |
| ------------- |:-------------:|:-----------------:|:-------------:|
| ?users=login               | POST        |      | add user token key |
| ?users=ins                 | POST        |      | add user in the table. |
| ?users=allusernames        | GET         |      | returns it all user names. |
| ?users=datas               | GET         |  Y   | returns it the user datas who owns the token. |
| ?users=allusers            | GET         |  Y   | returns it all user datas. |
| ?users=delalltoken         | GET         |  Y   | tokens table truncate. |
| ?users=allusersmin         | POST        |      | returns it username, useremail, blogid, blogname. |
| ?users=mod                 | POST        |  Y   | add user. |
| ?users=del                 | POST        |  Y   | delet user by token. |
| ?users=allcat              | GET         |  Y   | returns it all user datas. |
| ?users=oneuser             | POST        |      | returns user datas. Based on userid. |
| ?users=rankmod             | POST        |  Y   | When the user is admin, the rank of other users can be changed. |


| Status Codes  |
| -------------------------- |
| 200   Ok! Token code back  |
| 201   Ok! Inserted         |
| 408   Request Timeout      |
| 401   Unautorized          |
| 400   Bad Request          |

## BLOGS:
| Query | Method | Token? | What is it doing |
| ------------- |:-------------:|:-----------------:|:-------------:|
| ?blogs=blogalldatas        | POST        |      | returns all data from the user's blog. |
| ?blogs=allcat              | GET         |      | return it all blog categories. |
| ?blogs=lastentries         | GET         |      | return it 5 lastest entrie. |
| ?blogs=userblogdatas       | POST        |  Y   | returns the blogbody data. If it doesn't exist, create it. |
| ?blogs=newentrie           | POST        |  Y   | insert new entrie. |
| ?blogs=getallentries       | POST        |  Y   | return all entries in blog. |
| ?blogs=getoneentrie        | POST        |  Y   | return one entrie datas. |
| ?blogs=mod                 | POST        |  Y   | universal data modification endpoint. |
| ?blogs=del                 | POST        |  Y   | delete data. |
| ?blogs=allblogs            | POST        |      | return it all blogsbody. |
| ?blogs=search              | POST        |      | searches for entries based on text. |

## COMMENTS:
| Query | Method | Token? | What is it doing |
| ------------- |:-------------:|:-----------------:|:-------------:|
| ?comments=allcomments      | POST        |      | return it all blogsbody. |
| ?comments=newcomment       | POST        |  Y   | insert a new comment. |
| ?comments=delcomment       | POST        |  Y   | delete comment. |

### TEST USERS:
| username    | email         | password          |
| ----------- |:-------------:|:-----------------:|
| admin       | admin@mdblog.com		 | 123456 |
| Dániel      | daniel@mdblog.com		 | abcdef |
| SteveJonson |	stevejonson@mdblog.com	 | 123456 |
| DougieAdams |	adams@mdblog.com		 | 123456 |
| Charles     |	charles@mdblog.com		 | 123456 |
| Mike95      |	mike95@freeweb.com		 | 123456 |