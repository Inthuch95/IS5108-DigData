# IS5108-DigData
In order to access the website from the lab machine, "IS5108-DigData" folder should be copied to "nginx_default" folder.
In order to access the website from personal PC, you can use the url https://is5108group-4.host.cs.st-andrews.ac.uk/IS5108-DigData/.

Below are usernames and passwords for administrator:
phuriwat 123456
inthuch 123456
anna 123456
nattasan 123456

Usernames and passwords for regular users:
lara 123456   

#database setup for local PC
1. Open the SQL client on your computer.
2. Create database name "is5108group-4__digdata"
3. Go into that database
4. Choose import option
5. Browse file "is5108group-4__digdata_2018-04-27.sql" in IS5108-DigData folder and submit it

However, if the setting for the SQL client are not:

username="is5108group-4";
password="b9iVc.9gS8c7NJ";
$host="is5108group-4.host.cs.st-andrews.ac.uk";
db="is5108group-4__digdata";

You have to edit the file "databaseConfig.php" in the PHP folder.