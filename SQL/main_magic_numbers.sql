create table magic_numbers
(
    module_base_efficiency          DECIMAL default .8,
    base_multiplier_for_buy_vs_sell DECIMAL default .75,
    base_refinery_kwh               integer default 560,
    base_refinery_speed             DECIMAL default 1.3,
    base_drill_per_kw_hour          DECIMAL default 2,
    "markup_for_each_leg "          DECIMAL default .03,
    markup_total_change             DECIMAL default 1.03,
    base_weight_for_system_stock    DECIMAL default 2,
    other_server_weight             decimal default 1.0,
    distance_weight                 decimal default 0.0,
    server_id                       int,
    cost_kw_hour                    DECIMAL default 0.0012850929221,
    base_labor_per_hour             DECIMAL default 7707.81
);

INSERT INTO magic_numbers (module_base_efficiency, base_multiplier_for_buy_vs_sell, base_refinery_kwh, base_refinery_speed, base_drill_per_kw_hour, "markup_for_each_leg ", markup_total_change, base_weight_for_system_stock, other_server_weight, distance_weight, server_id, cost_kw_hour, base_labor_per_hour) VALUES (0.8, 0.75, 560, 1.3, 2, 0.03, 1.03, 2, 1, 1.1, 1, 0.0012850929221, 7707.81);