<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Region;

/**
 * RegionSearch represents the model behind the search form about `\app\models\Region`.
 */
class RegionSearch extends Region
{
    /**
     * @inheritdoc
     */
    public $currencyName;
    public $mixedSearch;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
            [['currencyName'], 'safe']
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
        $query = Region::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'currencyName' => [
                    'asc' => ['currency.name' => SORT_ASC],
                    'desc' => ['currency.name' => SORT_DESC],
                    'label' => 'Main Currency'
                ]
            ]
        ]);
        if(isset($params['search']))
            $this->mixedSearch = $params['search'];
        $this->load($params);
        $query->joinWith(['currency']);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'region.name', $this->name]);
        if($this->mixedSearch) {
             $query->andFilterWhere(['like', 'region.name', $this->mixedSearch])
                ->orFilterWhere(['like', 'currency.name', $this->mixedSearch]);
        }

        return $dataProvider;
    }
}
