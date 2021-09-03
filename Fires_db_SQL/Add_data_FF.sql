use forest_fires;
select COUNT(1) from place;
INSERT INTO place (coord_lat, coord_lon, region, frst_name, qrt_num, frstr_name, srf_act, obs_pnt_dist, obs_pnt_dir) 
VALUES (52.598134, 31.205144, 'Gomel', 'Vetka', '421', 'Vetka', 1480, 23.4, 'NE');
select * from place;
INSERT INTO fire (place_id, dt_occur, square, type) VALUES (68, '2012-07-29', 0.08, 'srf');
select * from fire;
INSERT INTO meteo (wnd_dir, wnd_vel, Temp, fallout, Hmdt) 
VALUES ('SE', 3.0, 31.7, 0.0, 28);
select * from meteo;
INSERT INTO rad (dt_obs, as_hp, av, av_bgrnd, obs_pnt_name) 
VALUES ('2012-07-29', 0.6, 25.0, 19.9,'Gomel');
select * from rad;
INSERT INTO obs_pnt (place_id, rad_id, meteo_id)
VALUES (68, 68, 68);
Select * from obs_pnt; 

select coord_lat, coord_lon, frstr_name, qrt_num FROM place
WHERE obs_pnt_dist < 30
group by qrt_num;