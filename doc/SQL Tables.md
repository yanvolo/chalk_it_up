#SQL Tables

##`user_`
Basic user data (the underscore is b/c user is a reserved word in SQL).

- `uid`: Base 64 encoded 16 byte unique randomly generated id.
- `login_name`: Name entered when loggin in. e.g. bob
- `display_name`: Name displayed. e.g. Bob Ross

		CREATE TABLE user_ (  
			uid CHAR(24) PRIMARY KEY,  
			login_name NCHAR VARYING NOT NULL UNIQUE,  
			display_name NCHAR VARYING NOT NULL  
			);  

##`auth_native`
Authentication through the website, rather then something like OAuth.

- `uid`: References `user_(uid)`.
- `secret_hash_type`: Arbitrary chosen, but random(tm) id for hash function used. e.g. c34d5d is used for bcrypt as it is the first 6 characters of `base16(sha1(bcrypt("bcrypt", cost: 4, salt: "bcryptbcryptbcryptbcry")))`.
- `secret_hash`: Hash of user's secret.
- `hash_type_specific`: Data specific to hash function such as a salt, or a difficulty setting.

		CREATE TABLE auth_native (  
			uid CHAR(24) PRIMARY KEY REFERENCES user_(uid),  
			secret_hash_type CHAR(6) NOT NULL,  
			secret_hash CHAR VARYING NOT NULL,  
			hash_type_specific CHAR VARYING  
			);  

##`auth_google`

		CREATE TABLE oauth_google (
			oauth_googleid CHAR VARYING PRIMARY KEY,
			google_display_name NCHAR VARYING,
			google_email CHAR VARYING,
			uid CHAR(24) REFERENCES user_(uid) NOT NULL
			);


#`session_`
Sessions of users currently logged in (session also a SQL reserved word).

- `sessionid`: Base 64 encoded 16 byte unique randomly generated id.
- `uid`: References `user_(uid)`.
- `last_ip`: IP used on last page load. 45 characters can be achieved by encoding an IPv4 address in IPv6 address style.
- `start_time`: Seconds since Jan 1st, 1970 when the session was started.

		CREATE TABLE session_ (  
			sessionid CHAR(24) PRIMARY KEY,  
			uid CHAR(24) REFERENCES user_(uid),  
			last_ip CHAR(45) NOT NULL,  
			start_time BIGINT NOT NULL  
			);  

#`class`

		CREATE TABLE class (  
			classid CHAR(24) PRIMARY KEY,  
			display_name NCHAR VARYING NOT NULL
			);  

#`boss`

		CREATE TABLE boss (  
			bossid CHAR(24) PRIMARY KEY,  
			classid CHAR(24) REFERENCES class(classid) NOT NULL,  
			display_name NCHAR VARYING NOT NULL,  
			img_url CHAR VARYING NOT NULL,  
			hp INT NOT NULL  
			);  

#`class_teacher_link`

		CREATE TABLE class_teacher_link (  
			classid CHAR(24) REFERENCES class(classid),  
			uid CHAR(24) REFERENCES user_(uid),  
			PRIMARY KEY(classid, uid)  
			);  

#`class_student_link`

		CREATE TABLE class_student_link (  
			classid CHAR(24) REFERENCES class(classid),  
			uid CHAR(24) REFERENCES user_(uid),  
			PRIMARY KEY(classid, uid)  
			);  

#`class_deck_link`

		CREATE TABLE class_deck_link (  
			classid CHAR(24) REFERENCES class(classid),  
			deckid CHAR(24) REFERENCES deck(deckid),  
			PRIMARY KEY(classid, deckid)  
			);  

#`deck`

		CREATE TABLE deck (  
			deckid CHAR(24) PRIMARY KEY,  
			owner CHAR(24) REFERENCES user_(uid) NOT NULL,  
			display_name NCHAR VARYING NOT NULL,  
			description NCHAR VARYING NOT NULL,  
			questionids_csv NCHAR VARYING NOT NULL  
			);  

#`card`

		CREATE TABLE card (  
			cardid CHAR(24) PRIMARY KEY,  
			owner CHAR(24) REFERENCES user_(uid) NOT NULL,  
			short NCHAR VARYING NOT NULL,  
			long NCHAR VARYING NOT NULL,  
			answers_csv NCHAR VARYING NOT NULL
			);  

#`admin`

		CREATE TABLE admin (  
			uid CHAR(24) REFERENCES user_(uid) NOT NULL,  
			permissions_csv CHAR VARYING NOT NULL
			);  
