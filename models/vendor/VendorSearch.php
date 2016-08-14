<?php

namespace app\models\vendor;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\vendor\Vendor;

/**
 * VendorSearch represents the model behind the search form about `app\models\vendor\Vendor`.
 */
class VendorSearch extends Vendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'comm_prices', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug', 'comm_note', 'admin_notes', 'payment_notes'], 'safe'],
            [['tax_rate', 'tax_service_rate', 'comm_rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Vendor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'organization_id' => $this->organization_id,
            'tax_rate' => $this->tax_rate,
            'tax_service_rate' => $this->tax_service_rate,
            'comm_prices' => $this->comm_prices,
            'comm_rate' => $this->comm_rate,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'comm_note', $this->comm_note])
            ->andFilterWhere(['like', 'admin_notes', $this->admin_notes])
            ->andFilterWhere(['like', 'payment_notes', $this->payment_notes]);

        return $dataProvider;
    }
}
