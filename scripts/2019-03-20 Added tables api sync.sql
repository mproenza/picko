CREATE TABLE `op_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `object_id` bigint(20) UNSIGNED NOT NULL,
  `type` char(1) NOT NULL,
  `created_by_id` char(36) DEFAULT NULL,
  `created_by_role` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `object_final_state` text,
  `descriptor` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `sync_events_queue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `sync_date` datetime DEFAULT NULL,
  `sync_batch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `op_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);
  
ALTER TABLE `sync_events_queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_opevent_queue` (`event_id`);
  
ALTER TABLE `op_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `sync_events_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `sync_events_queue`
  ADD CONSTRAINT `fk_opevent_queue` FOREIGN KEY (`event_id`) REFERENCES `op_events` (`id`);