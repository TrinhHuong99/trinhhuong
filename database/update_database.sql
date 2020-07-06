ALTER TABLE `hm-bookstore`.`republish` 
ADD COLUMN `status` TINYINT(1) NULL DEFAULT 0 COMMENT 'Trạng thái sử dụng' AFTER `republish`,
ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `hm-bookstore`.`sms_book` 
ADD COLUMN `sms_num` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Đầu số gửi tin' AFTER `email`;

ALTER TABLE `hm-bookstore`.`sms_book` 
ADD COLUMN `message` TEXT NULL DEFAULT NULL COMMENT 'Nội dung' AFTER `updated_at`;

CREATE TABLE IF NOT EXISTS `hm-bookstore`.`book_temp_mail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `book_code` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Mã sách',
  `title` VARCHAR(225) NULL DEFAULT NULL COMMENT 'Tiêu đề thư',
  `content` TEXT NULL DEFAULT NULL COMMENT 'Nội dung thư',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;