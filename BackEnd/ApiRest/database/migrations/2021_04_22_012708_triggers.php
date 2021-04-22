<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Triggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            'CREATE OR REPLACE TRIGGER INSERT_ORDER_PRODUCTS AFTER INSERT ON product_by_orders FOR EACH ROW
            BEGIN
                UPDATE orders SET
                    total = (total+(NEW.amount*(SELECT value FROM products WHERE id = NEW.product_id)))
                WHERE id = NEW.order_id;
            END;'
        );
        DB::unprepared(
            'CREATE OR REPLACE TRIGGER UPDATE_ORDER_PRODUCTS AFTER UPDATE ON product_by_orders FOR EACH ROW
            BEGIN
                UPDATE orders SET
                    total = (total-(OLD.amount*(SELECT value FROM products WHERE id = OLD.product_id)))
                WHERE id = OLD.order_id;
                UPDATE orders SET
                    total = (total+(NEW.amount*(SELECT value FROM products WHERE id = NEW.product_id)))
                WHERE id = NEW.order_id;
            END;'
        );
        DB::unprepared(
            'CREATE OR REPLACE TRIGGER DELETE_ORDER_PRODUCTS AFTER DELETE ON product_by_orders FOR EACH ROW
            BEGIN
                UPDATE orders SET
                    total = (total-(OLD.amount*(SELECT value FROM products WHERE id = OLD.product_id)))
                WHERE id = OLD.order_id;
            END;'
        );
        DB::unprepared(
            'CREATE OR REPLACE TRIGGER UPDATE_PRODUCTS BEFORE UPDATE ON products FOR EACH ROW
            BEGIN
                DECLARE finished INTEGER DEFAULT 0;
                DECLARE v_order_id BIGINT DEFAULT 0;
                DECLARE v_amount BIGINT DEFAULT 0;
                DECLARE curOrders 
                    CURSOR FOR 
                        SELECT order_id, amount FROM product_by_orders WHERE product_id = OLD.id;
                DECLARE CONTINUE HANDLER 
                    FOR NOT FOUND SET finished = 1;
                IF(NEW.value != OLD.value) THEN 
                   OPEN curOrders;
                   getOrders: LOOP
                      FETCH curOrders INTO v_order_id, v_amount;
                        IF finished = 1 THEN 
                            LEAVE getOrders;
                        END IF;
                        UPDATE orders SET total = (total - (OLD.value*v_amount) + (NEW.value*v_amount)) WHERE id = v_order_id;
                    END LOOP getOrders;
                    CLOSE curOrders;
                END IF;
            END;'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER insert_order_products');
        DB::unprepared('DROP TRIGGER update_order_products');
        DB::unprepared('DROP TRIGGER delete_order_products');
        DB::unprepared('DROP TRIGGER update_products');
    }
}
