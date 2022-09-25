CREATE TABLE `4182102_testtask`.`users` (
  `phone` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `point` JSON NOT NULL,
  `contact` JSON NOT NULL
);

CREATE TABLE `4182102_testtask`.`carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(24) NOT NULL,
  `data` JSON NOT NULL,
  `payment` JSON NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `4182102_testtask`.`users`
(`phone`,
`password`,
`point`,
`contact`)
VALUES
('9012345678',
'admin',
'{"key":{"basic":"73dc760f4cd2a081","secret":"2FSK/31pWLipRXaBHKWlm6HV8/ZNX6J4WxGyLVGjAhE="}}',
'{"region":"US","lang":"en_US"}');

INSERT INTO `4182102_testtask`.`users`
(`phone`,
`password`,
`point`,
`contact`)
VALUES
('9876543210',
'moderator',
'{"key":{"basic":"f3fa628473c1bde3","secret":"RSEUrPYB/NXp28moft/Y/lBLbJoqkTlSREwAWlkURpU="}}',
'{"region":"NL","lang":"nl_NL"}');

