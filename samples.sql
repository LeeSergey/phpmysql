CREATE TABLE `product_images` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL DEFAULT '',
    `product_id` int unsigned NOT NULL,
    `path` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
)