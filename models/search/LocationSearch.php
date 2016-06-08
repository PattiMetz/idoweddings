<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Location;

/**
 * LocationSearch represents the model behind the search form about `\app\models\Location`.
 */
class LocationSearch extends Location
{
    
    public $regionName;
    public $destinationName;
    public $mixedSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'destination_id'], 'integer'],
            [['name', 'airport'], 'safe'],
            [['regionName','destinationName'], 'safe']
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
    public function search($params = array())
    {
        $query = Location::find();
        // add conditions that should always apply here
        if(isset($params['search']))
            $this->mixedSearch = $params['search'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'attributes' => [
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'label' => 'Name'
                    ],
                    
                    'destinationName' => [
                        'asc' => ['destination.name' => SORT_ASC],
                        'desc' => ['destination.name' => SORT_DESC],
                        'label' => 'Destination'
                    ]
                ]
            ]
        ]);

        $this->load($params);
        $query->joinWith(['destination']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'destination_id' => $this->destination_id,
        ]);
        if ($this->name) {
            $query->andFilterWhere(['like', 'location.name', $this->name])
               
                ->andFilterWhere(['like', 'airport', $this->airport]);
        }
        if($this->mixedSearch) {
             $query->andFilterWhere(['like', 'location.name', $this->mixedSearch])
                ->orFilterWhere(['like', 'destination.name', $this->mixedSearch])
                ->orFilterWhere(['like', 'airport', $this->mixedSearch]);
        }
            

        return $dataProvider;
    }
}
