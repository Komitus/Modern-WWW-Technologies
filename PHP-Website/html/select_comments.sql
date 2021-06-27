/*
DROP PROCEDURE IF EXISTS select_comments_index;
delimiter //
create procedure select_comments_index()
begin
	SELECT user, text, date FROM comments_index INNER JOIN users on comments_index.user_id = users.id;	
end //
delimiter ;
#GRANT EXECUTE ON `MyWebsite`.select_comments_index TO 'user'@'localhost'; 


DROP PROCEDURE IF EXISTS select_comments_hobby;
delimiter //
create procedure select_comments_hobby()
begin
	SELECT user, text, date FROM comments_hobby INNER JOIN users on comments_hobby.user_id = users.id;	
end //
delimiter ;
#GRANT EXECUTE ON `MyWebsite`.select_comments_hobby TO 'user'@'localhost'; 


DROP PROCEDURE IF EXISTS select_comments_hobby;
delimiter //
create procedure select_comments_science()
begin
	SELECT user, text, date FROM comments_science INNER JOIN users on comments_science.user_id = users.id;		
end //
delimiter ;
#GRANT EXECUTE ON `MyWebsite`.select_comments_science TO 'user'@'localhost'; 
*/
DROP PROCEDURE IF EXISTS select_comments;
delimiter //
create procedure select_comments(typed_article_name varchar(80))
begin
	SELECT article_num into @article_id FROM articles_ids WHERE article_name = typed_article_name;
	SELECT user, text FROM 
		(SELECT * FROM comments WHERE article_id = @article_id) as tmp_comments
			INNER JOIN 
		(SELECT user, id FROM users) as tmp_users ON tmp_comments.user_id = tmp_users.id;
end //
delimiter ;
GRANT EXECUTE ON `MyWebsite`.select_comments TO 'user'@'localhost'; 

DROP PROCEDURE IF EXISTS add_comment;
delimiter //
create procedure add_comment(typed_article_name varchar(80), typed_username varchar(80), content varchar(500))
begin
	SELECT article_num into @article_id FROM articles_ids WHERE article_name = typed_article_name;
	SELECT id into @userID FROM users WHERE user = typed_username;
	set @q = "insert into comments(user_id, article_id, text) values (?, ?, ?)";
	prepare stmt from @q;
	execute stmt using @userID, @article_id, content;
	deallocate prepare stmt;	
end //
delimiter ;
GRANT EXECUTE ON `MyWebsite`.add_comment TO 'user'@'localhost'; 


