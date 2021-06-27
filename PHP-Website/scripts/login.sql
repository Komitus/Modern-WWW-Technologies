DROP PROCEDURE IF EXISTS loginUser;
DELIMITER //
create procedure `loginUser`(login varchar(90), password varchar(90))
begin
	select 0 into @userId;
	set @q = "SELECT id, user into @userId, @userName  FROM users WHERE user = ? AND pass = ?";
	prepare stmt from @q;
	set @password = (select md5(password));
	execute stmt using login, @password;
	deallocate prepare stmt;
	SELECT @userId as id, @userName as user;
END //
DELIMITER ;

#GRANT EXECUTE ON `MyWebsite`.loginUser TO 'user'@'localhost'; 
