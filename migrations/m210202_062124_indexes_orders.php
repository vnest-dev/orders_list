<?php

use yii\db\Migration;

/**
 * Class m210202_062124_indexes_orders
 */
class m210202_062124_indexes_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "
        alter table orders
	    add constraint orders_users_id_fk
		foreign key (user_id) references users (id)
			on update cascade on delete cascade,
		add constraint orders_services_id_fk
        foreign key (service_id) references services (id)
                on update cascade on delete cascade;

        create index orders_mode_service_id_index
            on orders (mode, service_id);
        
        create index orders_mode_user_id_index
            on orders (mode, user_id);
        
        create index orders_status_mode_index
            on orders (status, mode);
        
        create index orders_status_service_id_index
            on orders (status, service_id);
        
        create index orders_status_user_id_index
            on orders (status, user_id);

        ";

        $this->execute($sql);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210202_062124_indexes_orders cannot be reverted.\n";

        return false;
    }
    */
}
