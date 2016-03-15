-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2016 at 12:04 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.17-2+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dictionary`
--

-- --------------------------------------------------------



INSERT INTO `users` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'milos1', 'milos1', 'milos@joiz.ch', 'milos@joiz.ch', 1, '2c0zol0dk5c0k4koc0s80o4ko84wss8', '/mvJhlMb870ENV2k9L+b5PSzv14chYK3b/qUTCLtxVY9YIbEvUNHcnHjdRJLsvb/j4dXy2wMqNqGZIru2d07MA==', '2016-03-07 23:48:20', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL),
(2, 'milica', 'milica', 'milica@gmail.com', 'milica@gmail.com', 1, 'eo0226ezkqgwwkg84swo04sg8wockg8', '7HTtdE04Dxwncetrn2rGI5Lzxg0ounZ21NecchrmVkHwUkwzlCxHU54ZVfqtqIxHJLPxEwUCuFK0wlcqQQedXg==', '2015-05-24 05:33:28', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(3, 'miki', 'miki', 'miodrag@gmail.com', 'miodrag@gmail.com', 1, '8rz1nhbeqb0ossos0c0wcs8cg8so0w4', 'LQ04bE9TZyYLKxLW8Z36DqoNiOLRW0mwCP2WA503M79Yu6LS5ouYTtpXjR8z78co6AVXcVEqKrjD2Mi6PBqYyA==', '2015-02-22 19:48:09', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(4, 'kukipei', 'kukipei', 'kukipei@gmail.com', 'kukipei@gmail.com', 1, 'avkcy7fyjt440s8k4wggs4kkwsko4kg', 'E3Vp/MmvPZsWR+jasJFYDlikpiJgbgxVQrU7h+MtWD0MkdUnNhO+mdjbKdhQwqI6rMZCOHHK9Z6U5EsfyPKCbQ==', '2015-05-04 08:23:26', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(5, 'ilija', 'ilija', 'ilijastojkovic@yahoo.com', 'ilijastojkovic@yahoo.com', 1, 'rccjlpzp6tc40c44wg8w80wowwc44ok', 'f793nIBQYclPGIyjIUNibevI3maiKcVXIpr6VlvWc9q5o00OSpXft2oCdbb6dEHXDuRnmvMprlROp6dvkCQXjA==', '2015-05-04 12:21:46', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(6, 'ivan', 'ivan', 'ivan@joiz.ch', 'ivan@joiz.ch', 1, '6b2ueihweswsw0owcockgk8g00sck0', '3zvCKiwvh4118I8dbNTNbO9i+7PMdwgG4WemLu1c48QA3M1uB4MxyhRBGtqg5ehdBb4LhQQRvp3V+HQz3zrN3w==', '2014-10-07 08:30:21', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(7, 'test', 'test', 'test@milosnovicevic.com', 'test@milosnovicevic.com', 1, 'o8dbwqz3ry8w8gw8gcscgcs44gco8gg', 'Su6GqGcHFADnpGPHGyGEh5k6yITDAoJObKNlqlwgtn5fPl/PrEeh52LipfVI++UZrw2V9MFvCFWpt7faRkUevA==', '2015-03-18 21:20:36', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(8, 'makroman', 'makroman', 'milanjanjic@gmail.com', 'milanjanjic@gmail.com', 1, '2c0zol0dk5c0k4koc0s80o4ko84wss8', '/mvJhlMb870ENV2k9L+b5PSzv14chYK3b/qUTCLtxVY9YIbEvUNHcnHjdRJLsvb/j4dXy2wMqNqGZIru2d07MA==', '2015-03-22 20:24:26', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(9, 'stojke', 'stojke', 'stojke@stojke.com', 'stojke@stojke.com', 1, 'pz3whk09e80wg0oswsgkg04so8k8s8g', 'cbFfIo5H9dzCUE6Q+ZMPaSRQZHvk6EdXSmwY/T0ow/h2Zi2auhbAdKUdl0b6wz1DD47Y7ydCvce6o36cvNRkWQ==', '2014-11-06 14:54:39', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(10, 'Tandi22', 'tandi22', 'nikola_tandara@hotmail.com', 'nikola_tandara@hotmail.com', 1, 'nytfdrdmxlc88448wg0ggo4w0s08ggs', 'xGkCihbdKRULkqxdvo+dRm0qjkZGlSXf1oKehNiofT2VtP7iF2PPikXrZLuu+k00yw1gsNa3PMirDlBSR98H4w==', '2015-01-02 13:13:23', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(11, 'archness', 'archness', 'vanja.car@gmail.com', 'vanja.car@gmail.com', 1, 'cw0sz0enynsws0ow0wgs4s8cks4c8cw', 'OCbeVSxNQQdl9EOGpmiwjfp6B2sgHPErbA6ShHcFipnGhl8gCSxTkmDiKkgYzlP6Ja78ZAHpWKuFeOaF3y+4Ew==', '2015-01-12 23:51:52', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(12, 'doljaca', 'doljaca', 'doljaca.os@gmail.com', 'doljaca.os@gmail.com', 1, 'j1ca0ixzgnk84o8ocww0gccoo4ckwc4', 'gw+X3vHBLzx0ldPbEO2zJUpRk7jLvabQHoZeavaUKZ1YUrAIc9AXzL3ry9I7jRUQi77Othb+Rs0qeESH0+SFCg==', '2015-01-21 00:46:06', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(13, 'zoran', 'zoran', 'zoran@gmail.com', 'zoran@gmail.com', 1, '1dmu61cs4lr4g4gs8ogkk08woooc08c', 'YFvr1dEuKKfep3jk23OMyrYEDSxpckqbi5bnr/O0ysC9Pzr9gEulSn4jq49yXtA4w0BU/QtDy7Fw8XOwrs5gGQ==', '2015-06-14 20:03:02', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
