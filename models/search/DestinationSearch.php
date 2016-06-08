<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Destination;

/**
 * DestinationSearch represents the model behind the search form about `\app\models\Destination`.
 */
class DestinationSearch extends Destination
{
    /**
     * @inheritdoc
     */
    public $regionName;
    public $currencyName;
    public $mixedSearch;

    public function rules()
    {
        return [
            [['id', 'region_id', 'currency_id', 'active'], 'integer'],
            [['name'], 'safe'],
            [['regionName','currencyName'], 'safe']
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
        $query = Destination::find();

        // add conditions that should always apply here
        if(isset($params['search']))
            $this->mixedSearch = $params['search'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'regionName' => [
                    'asc' => ['region.name' => SORT_ASC],
                    'desc' => ['region.name' => SORT_DESC],
                    'label' => 'Region'
                ],
                'currencyName' => [
                    'asc' => ['currency.name' => SORT_ASC],
                    'desc' => ['currency.name' => SORT_DESC],
                    'label' => 'Main Currency'
                ]
            ]
        ]);

        $this->load($params);
        $query->joinWith(['region']);
        $query->joinWith(['currency']);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'region_id' => $this->region_id,
            'currency_id' => $this->currency_id,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'destination.name', $this->name]);
        if($this->mixedSearch) {
             $query->andFilterWhere(['like', 'region.name', $this->mixedSearch])
                ->orFilterWhere(['like', 'destination.name', $this->mixedSearch])
                ->orFilterWhere(['like', 'currency.name', $this->mixedSearch]);
        }
        return $dataProvider;
    }
}
