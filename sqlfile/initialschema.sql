CREATE TABLE IF NOT EXISTS `User` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(256) NOT NULL UNIQUE,
    `password` varchar(256) NOT NULL,
    `username` varchar(265) NOT NULL UNIQUE,
    `is_admin` boolean NOT NULL DEFAULT false,
    PRIMARY KEY (`user_id`)
    );

CREATE TABLE IF NOT EXISTS `Album` (
    `album_id` int(11) NOT NULL AUTO_INCREMENT,
    `album_title` varchar(256) NOT NULL,
    `singer` varchar(128) NOT NULL,
    `total_duration` int(11) NOT NULL DEFAULT 0,
    `image_path` varchar(256) NOT NULL,
    `publish_date` date NOT NULL,
    `genre` varchar(256) NOT NULL,
    PRIMARY KEY (`album_id`)
    );

ALTER TABLE `Album` ADD UNIQUE `unique_index`(`album_title`, `singer`);

CREATE TABLE IF NOT EXISTS `Song` (
    `song_id` int(11) NOT NULL AUTO_INCREMENT,
    `song_title` varchar(256) NOT NULL,
    `singer` varchar(128) NOT NULL,
    `publish_date` date NOT NULL,
    `genre` varchar(64),
    `duration` int(11) NOT NULL,
    `audio_path` varchar(256) NOT NULL,
    `image_path` varchar(256),
    `album_id` int(11),
    PRIMARY KEY (`song_id`),
    FOREIGN KEY (`album_id`) REFERENCES `Album`(`album_id`) ON DELETE SET NULL
    );

CREATE TABLE IF NOT EXISTS `Subscription` (
    `creator_id` int(11) NOT NULL,
    `subscriber_id` int(11) NOT NULL,
    `status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    PRIMARY KEY (`creator_id`, `subscriber_id`),
    FOREIGN KEY (`subscriber_id`) REFERENCES `User`(`user_id`) ON DELETE CASCADE
);



-- create trigger
CREATE TRIGGER update_album_total_duration_on_insert
AFTER INSERT ON Song
FOR EACH ROW 
UPDATE Album 
SET total_duration = total_duration + NEW.duration
WHERE Album.album_id = NEW.album_id;

CREATE TRIGGER update_album_total_duration_on_update
BEFORE UPDATE ON Song
FOR EACH ROW
UPDATE Album
SET total_duration = total_duration - OLD.duration
WHERE Album.album_id = OLD.album_id;

CREATE TRIGGER update_album_total_duration_on_delete
BEFORE DELETE ON Song
FOR EACH ROW 
UPDATE Album 
SET total_duration = total_duration - OLD.duration
WHERE Album.album_id = OLD.album_id;


    


-- insert intial data
-- insert admin
INSERT INTO `User` (`name`, `email`, `password`, `username`, `is_admin`) VALUES
('admin', 'admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', true);
-- insert user
INSERT INTO `User` (`name`, `email`, `password`, `username`, `is_admin`) VALUES
('user', 'user@user.com', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', 'user', false);

-- add album
-- i met you when i was 18
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('I Met You When I Was 18', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('How Im Feeling', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('C', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('F', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('J', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('M', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('K', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('N', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');

INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('sasdad', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('ghgh', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('ebrt', 'lauv', 0, 'i_met_you_when_i_was_18.jpg', '2018-01-01', 'Pop');
-- how im feeling
INSERT INTO `Album` (`album_title`, `singer`, `total_duration`, `image_path`, `publish_date`, `genre`) VALUES
('eayb', 'lauv', 0, 'how_im_feeling.jpg', '2018-01-01', 'Pop');


-- add song
-- i like me better
INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
('I Like Me Better', 'lauv', '2018-01-01', 'Pop', 197, 'i_like_me_better.mp3', 'i_like_me_better.jpg', 1);

-- the other
INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
('The Other', 'lauv', '2018-01-01', 'Pop', 309, 'the_other.mp3', 'the_other.jpg', 1);

-- mean it
INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
('Mean It', 'lauv', '2020-01-01', 'Pop', 243, 'mean_it.mp3', 'mean_it.jpg', 2);

INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`) VALUES
('Tak Beralbum 1', 'lauv', '2020-01-01', 'Pop', 243, 'mean_it.mp3', 'mean_it.jpg');

INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`) VALUES
('Tak Beralbum 2', 'lauv', '2020-01-01', 'Pop', 243, 'mean_it.mp3', 'mean_it.jpg');

INSERT INTO `Song` (`song_title`, `singer`, `publish_date`, `genre`, `duration`, `audio_path`, `image_path`) VALUES
('Tak Beralbum 3', 'lauv', '2020-01-01', 'Pop', 243, 'mean_it.mp3', 'mean_it.jpg');