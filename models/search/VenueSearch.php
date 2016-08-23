<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\venue\Venue as VenueModel;
use app\models\Destination;
use app\models\Region;
/**
 * Venue represents the model behind the search form about `app\models\venue\Venue`.
 */
class VenueSearch extends VenueModel
{
    public $region_id;
    public $destination_id;
    public $destinationName;
    public $locationName;
    public $airport;
    public $fullName;
    public $mixedSearch;    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'updated_by'], 'integer'],
            [['name', 'featured_name', 'active', 'featured', 'comment', 'guest_capacity', 'updated_at','location_id', 'type_id', 'vibe_id', 'service_id','region_id','destination_id', 'destinationName','locationName','airport', 'fullName'], 'safe'],
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
        $query = VenueModel::find();
        $old_destination_id = $old_region_id = '';
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'fullName' => [
                    'asc' => ['name' => SORT_ASC, 'featured_name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC, 'featured_name' => SORT_DESC],
                    'label' => 'Name<br/>Featured Name',
                    'default' => SORT_ASC
                ],
                'destinationName' => [
                    'asc' => ['destination.name' => SORT_ASC],
                    'desc' => ['destination.name' => SORT_DESC],
                    'label' => 'Destination'
                ],
                'locationName' => [
                    'asc' => ['location.name' => SORT_ASC],
                    'desc' => ['location.name' => SORT_DESC],
                    'label' => 'Location'
                ],
                'airport' => [
                    'asc' => ['location.airport' => SORT_ASC],
                    'desc' => ['location.airport' => SORT_DESC],
                    'label' => 'Airport Code'
                ],
                   
            ]
        ]);

        $this->load($params);
       // $this->location_id = $params['location_id'];
        if($this->location_id) {
            $old_region_id = $this->region_id;
            $old_destination_id = $this->destination_id;
            $this->destination_id = '';
            $this->region_id = '';
        }
        $query->joinWith(['destination']);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'location_id' => $this->location_id,
            'type_id' => $this->type_id,
            'vibe_id' => $this->vibe_id,
            'service_id' => $this->service_id,
            'updated_by' => $this->updated_by,
            'destination_id' => $this->destination_id,
            'region_id' =>$this->region_id
        ]);

        $query->andFilterWhere(['like', 'venue.name', $this->name])
            ->andFilterWhere(['like', 'featured_name', $this->featured_name])
            ->andFilterWhere(['like', 'featured', $this->featured])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'guest_capacity', $this->guest_capacity])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        if($this->location_id) {
           $this->destination_id = $old_destination_id;
           $this->region_id = $old_region_id; 
        }
        return $dataProvider;
    }
}
