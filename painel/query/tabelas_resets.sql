ALTER TABLE dbo.Character ADD Resets int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsDay int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsWeek int NOT NULL DEFAULT 0 
ALTER TABLE dbo.Character ADD ResetsMonth int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsWeekFree int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsWeekVip int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsWeekVip2 int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsMonthFree int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsMonthVip int NOT NULL DEFAULT 0
ALTER TABLE dbo.Character ADD ResetsMonthVip2 int NOT NULL DEFAULT 0

ALTER TABLE dbo.MEMB_INFO ADD Cash int NOT NULL DEFAULT 0