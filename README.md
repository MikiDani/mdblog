# MD Blog dokumentáció

Az MD Blog egy weboldal alapú blog portál. 
Az oldalnak a backend részéhez egy REST API alkalmazást készítettem ami JSON formátumban kommunikál. A kódot php nyelven írtam, és mysql-t használ az adatbázis tárolására. 
A frontend részét html-php nyelven írtam, ami mellett Bootstrap és jQuery keretrendszereket használtam.
Letöltéskor a backend/session_url.php-ban az elérési utat bekell álítani!

# Weboldal felépítése:

A weboldal két fő részre van osztva.
•	Blog Portal – index.php
•	Blog – blog.php?usernameCode
Blog Portál: Ez az felület az összes blogot és felhasználót összefogja. Itt betudunk jelentkezni, az összes blogról és felhasználóról tudhatunk meg információkat.
Blog oldal: Itt minden Blognot külön url címen tudunk elérni. Ez azért jó, mert a kedvelt blogjainkat egyből eltudjuk érni egy linkel. Nem kell külön a Portál oldalra menni és onnan elérni a tartalmat.

# MySQL szerkezet: a bacend / info.txt-ben szépen olvashatóak az információk.
-------------			-------------			--------------			 --------------
users:					blogbody:				blogentries:			 blogcomments:
-------------			-------------			--------------			 --------------
id 						blogid     ─────┐		entrieid	─────┐		 commentid
username				userid			└─────  blogid			 │		 userid
useremail				blogname				entrietitle		 └─────	 entrieid
userpassword			blogtitle				entriebody				 commenttext
userrank				categoryid				entrieepoch				 commentepoch
userinfo				startepoch				
imglink					bgimg					

# REST API Endpoints:

## USERS

| ?users=login               | POST        |      | add user token key                    |
|                              required inputs: { "usernameoremail", "userpassword" }
| ?users=ins                 | POST        |      | add user in the table.       |
|                              required inputs: { "username", "useremail", "userpassword" }
| ?users=allusernames        | GET         |      | returns it all user names.
| ?users=datas               | GET         |  Y   | returns it the user datas who owns the token.
| ?users=allusers            | GET         |  Y   | returns it all user datas.
| ?users=delalltoken         | GET         |  Y   | tokens table truncate.
| ?users=allusersmin         | POST        |      | returns it username, useremail, blogid, blogname.
| ?users=mod                 | POST        |  Y   | add user.
| ?users=del                 | POST        |  Y   | delet user by token.
| ?users=allcat              | GET         |  Y   | returns it all user datas.
| ?users=oneuser             | POST        |      | returns user datas. Based on userid.
| ?users=rankmod             | POST        |  Y   | When the user is admin, the rank of other users can be changed.
|                              required inputs: { "userid", "userrank" }

------------------------------
| ?users=login  | responses  |
|----------------------------|
| 200   Ok! Token code back  |
| 201   Ok! Inserted         |
| 408   Request Timeout      |
| 401   Unautorized          |
| 400   Bad Request          |
------------------------------

## BLOGS:

| ?blogs=blogalldatas        | POST        |      | returns all data from the user's blog.
| ?blogs=allcat              | GET         |      | return it all blog categories.
| ?blogs=lastentries         | GET         |      | return it 5 lastest entrie.
| ?blogs=userblogdatas       | POST        |  Y   | returns the blogbody data. If it doesn't exist, create it.
| ?blogs=newentrie           | POST        |  Y   | insert new entrie.
|                              required inputs: { "blogid", "entrietitle", "entriebody" }
| ?blogs=getallentries       | POST        |  Y   | return all entries in blog
|                              required input:  { "blogid" }
| ?blogs=getoneentrie        | POST        |  Y   | return one entrie datas.
|                              required input:  { "entrieid" }
| ?blogs=mod                 | POST        |  Y   | universal data modification endpoint.
                               required inputs: { "tabledatas": {"tablename", "idkeyname", "idvalue"}, "celldatas": { "key": "value", listing... } }
| ?blogs=del                 | POST        |  Y   | delete data 
|                              required inputs:    { "tablename", "idkeyname":, "idvalue" }
| ?blogs=allblogs            | POST        |      | return it all blogsbody.
|                              possibility:     { "orderby", "filterkey", "filtervalue" }
| ?blogs=search              | POST        |      | searches for entries based on text.
|                              required input:  { "input", "location" }

## COMMENTS:

| ?comments=allcomments      | POST        |      | return it all blogsbody.
|                              required inputs:    { "entrieid" }
| ?comments=newcomment       | POST        |  Y   | insert a new comment.
|                              required input: { "userid", "entrieid", "commenttext" }
| ?comments=delcomment       | POST        |  Y   | delete comment.
|                              required input: { "commentid" }

### TEST USERS:

admin			admin@mdblog.com		123456
Dániel			daniel@mdblog.com		abcdef
SteveJonson		stevejonson@mdblog.com	123456
DougieAdams		adams@mdblog.com		123456
Charles			charles@mdblog.com		123456
Mike95			mike95@freeweb.com		123456