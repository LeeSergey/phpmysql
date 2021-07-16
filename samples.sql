CREATE TABLE `product_images` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL DEFAULT '',
    `product_id` int unsigned NOT NULL,
    `path` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
)

CREATE TABLE `tasks_queue`(
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL DEFAULT '',
    `task` varchar(255) NOT NULL DEFAULT '',
    `params` text NOT NULL,
    `status` ENUM('new', 'in_process', 'done') DEFAULT 'new',
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);