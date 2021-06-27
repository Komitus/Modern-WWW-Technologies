DROP PROCEDURE IF EXISTS addUser;
delimiter //
create procedure addUser(typed_login varchar(80), password varchar(80) )
begin
	select count(id)  into @userExist FROM users where user = typed_login; 
	if @userExist < 1 then 
			set @q = "insert into users(user, pass) values (?, ?)";
			prepare stmt from @q;
			set @password  = (select md5(password));
			execute stmt using typed_login, @password;
			deallocate prepare stmt;
			select 1 as result;		
	else select 0 as result; 
	End if;
end //
delimiter ;

GRANT EXECUTE ON `MyWebsite`.addUser TO 'user'@'localhost'; 
