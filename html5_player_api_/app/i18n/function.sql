--
-- Fonctions
--
DROP FUNCTION IF EXISTS `cei_process_special_chars`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `cei_process_special_chars`(`textvalue` VARCHAR(500)) RETURNS varchar(500) CHARSET latin1
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
BEGIN

SET @textvalue = textvalue;


SET @withaccents = 'ŠšŽžÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝŸÞàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿþƒ';
SET @withoutaccents = 'SsZzAAAAAAACEEEEIIIINOOOOOOUUUUYYBaaaaaaaceeeeiiiinoooooouuuuyybf';
SET @count = LENGTH(@withaccents);

    WHILE @count > 0 DO
        SET @textvalue = REPLACE(@textvalue, SUBSTRING(@withaccents, @count, 1), SUBSTRING(@withoutaccents, @count, 1));
        SET @count = @count - 1;
    END WHILE;


    SET @special = '«»’”“!@#$%¨&()_+=§¹²³£¢¬"`´{[^~}]<,>.:;?/°ºª+|';
    
    SET @count = LENGTH(@special);
    
    WHILE @count > 0 do
        SET @textvalue = REPLACE(@textvalue, SUBSTRING(@special, @count, 1), '');
        SET @count = @count - 1;
    END WHILE;

    RETURN REPLACE( @textvalue, "'", '');
END$$

DELIMITER ;
