<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;
use Exception;
use IntlDateFormatter;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{


    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        //restrict customer access to view list of users
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view users'));
        } else {
            $key = $this->request->getQuery('key');
            if ($key) {
                $query = $this->paginate($this->Users->find('all')
                    ->where(['Or' => ['first_name like' => '%' . $key . '%', 'last_name like' => '%' . $key . '%',
                        'email like' => '%' . $key . '%', 'role like' => '%' . $key . '%']]));
            } else {
                $query = $this->paginate($this->Users->find('all'), ['limit' => 20]);
            }
            $users = $query;
//            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        }

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //restrict customer access to view a specific user
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view users'));
        } else {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);

            $this->set(compact('user'));
        }
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //restrict customer access to add users
        $getIdentity = $this->request->getAttribute('authentication')->getIdentity();
        $countries = array(
            "Afghanistan" => "Afghanistan",
            "Albania" => "Albania",
            "Algeria" => "Algeria",
            "American Samoa" => "American Samoa",
            "Andorra" => "Andorra",
            "Angola" => "Angola",
            "Anguilla" => "Anguilla",
            "Antarctica" => "Antarctica",
            "Antigua and Barbuda" => "Antigua and Barbuda",
            "Argentina" => "Argentina",
            "Armenia" => "Armenia",
            "Aruba" => "Aruba",
            "Australia" => "Australia",
            "Austria" => "Austria",
            "Azerbaijan" => "Azerbaijan",
            "Bahamas" => "Bahamas",
            "Bahrain" => "Bahrain",
            "Bangladesh" => "Bangladesh",
            "Barbados" => "Barbados",
            "Belarus" => "Belarus",
            "Belgium" => "Belgium",
            "Belize" => "Belize",
            "Benin" => "Benin",
            "Bermuda" => "Bermuda",
            "Bhutan" => "Bhutan",
            "Bolivia" => "Bolivia",
            "Bosnia and Herzegovina" => "Bosnia and Herzegovina",
            "Botswana" => "Botswana",
            "Bouvet Island" => "Bouvet Island",
            "Brazil" => "Brazil",
            "British Indian Ocean Territory" => "British Indian Ocean Territory",
            "Brunei Darussalam" => "Brunei Darussalam",
            "Bulgaria" => "Bulgaria",
            "Burkina Faso" => "Burkina Faso",
            "Burundi" => "Burundi",
            "Cambodia" => "Cambodia",
            "Cameroon" => "Cameroon",
            "Canada" => "Canada",
            "Cape Verde" => "Cape Verde",
            "Cayman Islands" => "Cayman Islands",
            "Central African Republic" => "Central African Republic",
            "Chad" => "Chad",
            "Chile" => "Chile",
            "China" => "China",
            "Christmas Island" => "Christmas Island",
            "Cocos (Keeling) Islands" => "Cocos (Keeling) Islands",
            "Colombia" => "Colombia",
            "Comoros" => "Comoros",
            "Congo" => "Congo",
            "Congo, the Democratic Republic of the" => "Congo, the Democratic Republic of the",
            "Cook Islands" => "Cook Islands",
            "Costa Rica" => "Costa Rica",
            "Cote D'Ivoire" => "Cote D'Ivoire",
            "Croatia" => "Croatia",
            "Cuba" => "Cuba",
            "Cyprus" => "Cyprus",
            "Czech Republic" => "Czech Republic",
            "Denmark" => "Denmark",
            "Djibouti" => "Djibouti",
            "Dominica" => "Dominica",
            "Dominican Republic" => "Dominican Republic",
            "Ecuador" => "Ecuador",
            "Egypt" => "Egypt",
            "El Salvador" => "El Salvador",
            "Equatorial Guinea" => "Equatorial Guinea",
            "Eritrea" => "Eritrea",
            "Estonia" => "Estonia",
            "Ethiopia" => "Ethiopia",
            "Falkland Islands (Malvinas)" => "Falkland Islands (Malvinas)",
            "Faroe Islands" => "Faroe Islands",
            "Fiji" => "Fiji",
            "Finland" => "Finland",
            "France" => "France",
            "French Guiana" => "French Guiana",
            "French Polynesia" => "French Polynesia",
            "French Southern Territories" => "French Southern Territories",
            "Gabon" => "Gabon",
            "Gambia" => "Gambia",
            "Georgia" => "Georgia",
            "Germany" => "Germany",
            "Ghana" => "Ghana",
            "Gibraltar" => "Gibraltar",
            "Greece" => "Greece",
            "Greenland" => "Greenland",
            "Grenada" => "Grenada",
            "Guadeloupe" => "Guadeloupe",
            "Guam" => "Guam",
            "Guatemala" => "Guatemala",
            "Guinea" => "Guinea",
            "Guinea-Bissau" => "Guinea-Bissau",
            "Guyana" => "Guyana",
            "Haiti" => "Haiti",
            "Heard Island and Mcdonald Islands" => "Heard Island and Mcdonald Islands",
            "Holy See (Vatican City State)" => "Holy See (Vatican City State)",
            "Honduras" => "Honduras",
            "Hong Kong" => "Hong Kong",
            "Hungary" => "Hungary",
            "Iceland" => "Iceland",
            "India" => "India",
            "Indonesia" => "Indonesia",
            "Iran, Islamic Republic of" => "Iran, Islamic Republic of",
            "Iraq" => "Iraq",
            "Ireland" => "Ireland",
            "Israel" => "Israel",
            "Italy" => "Italy",
            "Jamaica" => "Jamaica",
            "Japan" => "Japan",
            "Jordan" => "Jordan",
            "Kazakhstan" => "Kazakhstan",
            "Kenya" => "Kenya",
            "Kiribati" => "Kiribati",
            "Korea, Democratic People's Republic of" => "Korea, Democratic People's Republic of",
            "Korea, Republic of" => "Korea, Republic of",
            "Kuwait" => "Kuwait",
            "Kyrgyzstan" => "Kyrgyzstan",
            "Lao People's Democratic Republic" => "Lao People's Democratic Republic",
            "Latvia" => "Latvia",
            "Lebanon" => "Lebanon",
            "Lesotho" => "Lesotho",
            "Liberia" => "Liberia",
            "Libyan Arab Jamahiriya" => "Libyan Arab Jamahiriya",
            "Liechtenstein" => "Liechtenstein",
            "Lithuania" => "Lithuania",
            "Luxembourg" => "Luxembourg",
            "Macao" => "Macao",
            "Macedonia, the Former Yugoslav Republic of" => "Macedonia, the Former Yugoslav Republic of",
            "Madagascar" => "Madagascar",
            "Malawi" => "Malawi",
            "Malaysia" => "Malaysia",
            "Maldives" => "Maldives",
            "Mali" => "Mali",
            "Malta" => "Malta",
            "Marshall Islands" => "Marshall Islands",
            "Martinique" => "Martinique",
            "Mauritania" => "Mauritania",
            "Mauritius" => "Mauritius",
            "Mayotte" => "Mayotte",
            "Mexico" => "Mexico",
            "Micronesia, Federated States of" => "Micronesia, Federated States of",
            "Moldova, Republic of" => "Moldova, Republic of",
            "Monaco" => "Monaco",
            "Mongolia" => "Mongolia",
            "Montserrat" => "Montserrat",
            "Morocco" => "Morocco",
            "Mozambique" => "Mozambique",
            "Myanmar" => "Myanmar",
            "Namibia" => "Namibia",
            "Nauru" => "Nauru",
            "Nepal" => "Nepal",
            "Netherlands" => "Netherlands",
            "Netherlands Antilles" => "Netherlands Antilles",
            "New Caledonia" => "New Caledonia",
            "New Zealand" => "New Zealand",
            "Nicaragua" => "Nicaragua",
            "Niger" => "Niger",
            "Nigeria" => "Nigeria",
            "Niue" => "Niue",
            "Norfolk Island" => "Norfolk Island",
            "Northern Mariana Islands" => "Northern Mariana Islands",
            "Norway" => "Norway",
            "Oman" => "Oman",
            "Pakistan" => "Pakistan",
            "Palau" => "Palau",
            "Palestinian Territory, Occupied" => "Palestinian Territory, Occupied",
            "Panama" => "Panama",
            "Papua New Guinea" => "Papua New Guinea",
            "Paraguay" => "Paraguay",
            "Peru" => "Peru",
            "Philippines" => "Philippines",
            "Pitcairn" => "Pitcairn",
            "Poland" => "Poland",
            "Portugal" => "Portugal",
            "Puerto Rico" => "Puerto Rico",
            "Qatar" => "Qatar",
            "Reunion" => "Reunion",
            "Romania" => "Romania",
            "Russian Federation" => "Russian Federation",
            "Rwanda" => "Rwanda",
            "Saint Helena" => "Saint Helena",
            "Saint Kitts and Nevis" => "Saint Kitts and Nevis",
            "Saint Lucia" => "Saint Lucia",
            "Saint Pierre and Miquelon" => "Saint Pierre and Miquelon",
            "Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines",
            "Samoa" => "Samoa",
            "San Marino" => "San Marino",
            "Sao Tome and Principe" => "Sao Tome and Principe",
            "Saudi Arabia" => "Saudi Arabia",
            "Senegal" => "Senegal",
            "Serbia and Montenegro" => "Serbia and Montenegro",
            "Seychelles" => "Seychelles",
            "Sierra Leone" => "Sierra Leone",
            "Singapore" => "Singapore",
            "Slovakia" => "Slovakia",
            "Slovenia" => "Slovenia",
            "Solomon Islands" => "Solomon Islands",
            "Somalia" => "Somalia",
            "South Africa" => "South Africa",
            "South Georgia and the South Sandwich Islands" => "South Georgia and the South Sandwich Islands",
            "Spain" => "Spain",
            "Sri Lanka" => "Sri Lanka",
            "Sudan" => "Sudan",
            "Suriname" => "Suriname",
            "Svalbard and Jan Mayen" => "Svalbard and Jan Mayen",
            "Swaziland" => "Swaziland",
            "Sweden" => "Sweden",
            "Switzerland" => "Switzerland",
            "Syrian Arab Republic" => "Syrian Arab Republic",
            "Taiwan, Province of China" => "Taiwan, Province of China",
            "Tajikistan" => "Tajikistan",
            "Tanzania, United Republic of" => "Tanzania, United Republic of",
            "Thailand" => "Thailand",
            "Timor-Leste" => "Timor-Leste",
            "Togo" => "Togo",
            "Tokelau" => "Tokelau",
            "Tonga" => "Tonga",
            "Trinidad and Tobago" => "Trinidad and Tobago",
            "Tunisia" => "Tunisia",
            "Turkey" => "Turkey",
            "Turkmenistan" => "Turkmenistan",
            "Turks and Caicos Islands" => "Turks and Caicos Islands",
            "Tuvalu" => "Tuvalu",
            "Uganda" => "Uganda",
            "Ukraine" => "Ukraine",
            "United Arab Emirates" => "United Arab Emirates",
            "United Kingdom" => "United Kingdom",
            "United States" => "United States",
            "United States Minor Outlying Islands" => "United States Minor Outlying Islands",
            "Uruguay" => "Uruguay",
            "Uzbekistan" => "Uzbekistan",
            "Vanuatu" => "Vanuatu",
            "Venezuela" => "Venezuela",
            "Vietnam" => "Vietnam",
            "Virgin Islands, British" => "Virgin Islands, British",
            "Virgin Islands, U.s." => "Virgin Islands, U.s.",
            "Wallis and Futuna" => "Wallis and Futuna",
            "Western Sahara" => "Western Sahara",
            "Yemen" => "Yemen",
            "Zambia" => "Zambia",
            "Zimbabwe" => "Zimbabwe"
        );

        if ($getIdentity === null) {

            $user = $this->Users->newEmptyEntity();
            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('You have registered successfully.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('You have failed to register. Please, try again.'));
            }
            $this->set(compact('user', 'countries'));
        } else if ($getIdentity->get('role') === 'admin') {
            $user = $this->Users->newEmptyEntity();

            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user {0} {1} has been saved successfully.', $user->first_name, $user->last_name));

                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->set(compact('user', 'countries'));
        } else {
            //restrict customer access to view a specific user
            $userRole = $this->getRequest()->getAttribute('identity')->get('role');
            if ($userRole == 'customer') {
                $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
                $this->Flash->error(__('You are not authorised to view users'));
            }
        }

    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //restrict customer access to edit other users except themselves
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        $countries = array(
            "Afghanistan" => "Afghanistan",
            "Albania" => "Albania",
            "Algeria" => "Algeria",
            "American Samoa" => "American Samoa",
            "Andorra" => "Andorra",
            "Angola" => "Angola",
            "Anguilla" => "Anguilla",
            "Antarctica" => "Antarctica",
            "Antigua and Barbuda" => "Antigua and Barbuda",
            "Argentina" => "Argentina",
            "Armenia" => "Armenia",
            "Aruba" => "Aruba",
            "Australia" => "Australia",
            "Austria" => "Austria",
            "Azerbaijan" => "Azerbaijan",
            "Bahamas" => "Bahamas",
            "Bahrain" => "Bahrain",
            "Bangladesh" => "Bangladesh",
            "Barbados" => "Barbados",
            "Belarus" => "Belarus",
            "Belgium" => "Belgium",
            "Belize" => "Belize",
            "Benin" => "Benin",
            "Bermuda" => "Bermuda",
            "Bhutan" => "Bhutan",
            "Bolivia" => "Bolivia",
            "Bosnia and Herzegovina" => "Bosnia and Herzegovina",
            "Botswana" => "Botswana",
            "Bouvet Island" => "Bouvet Island",
            "Brazil" => "Brazil",
            "British Indian Ocean Territory" => "British Indian Ocean Territory",
            "Brunei Darussalam" => "Brunei Darussalam",
            "Bulgaria" => "Bulgaria",
            "Burkina Faso" => "Burkina Faso",
            "Burundi" => "Burundi",
            "Cambodia" => "Cambodia",
            "Cameroon" => "Cameroon",
            "Canada" => "Canada",
            "Cape Verde" => "Cape Verde",
            "Cayman Islands" => "Cayman Islands",
            "Central African Republic" => "Central African Republic",
            "Chad" => "Chad",
            "Chile" => "Chile",
            "China" => "China",
            "Christmas Island" => "Christmas Island",
            "Cocos (Keeling) Islands" => "Cocos (Keeling) Islands",
            "Colombia" => "Colombia",
            "Comoros" => "Comoros",
            "Congo" => "Congo",
            "Congo, the Democratic Republic of the" => "Congo, the Democratic Republic of the",
            "Cook Islands" => "Cook Islands",
            "Costa Rica" => "Costa Rica",
            "Cote D'Ivoire" => "Cote D'Ivoire",
            "Croatia" => "Croatia",
            "Cuba" => "Cuba",
            "Cyprus" => "Cyprus",
            "Czech Republic" => "Czech Republic",
            "Denmark" => "Denmark",
            "Djibouti" => "Djibouti",
            "Dominica" => "Dominica",
            "Dominican Republic" => "Dominican Republic",
            "Ecuador" => "Ecuador",
            "Egypt" => "Egypt",
            "El Salvador" => "El Salvador",
            "Equatorial Guinea" => "Equatorial Guinea",
            "Eritrea" => "Eritrea",
            "Estonia" => "Estonia",
            "Ethiopia" => "Ethiopia",
            "Falkland Islands (Malvinas)" => "Falkland Islands (Malvinas)",
            "Faroe Islands" => "Faroe Islands",
            "Fiji" => "Fiji",
            "Finland" => "Finland",
            "France" => "France",
            "French Guiana" => "French Guiana",
            "French Polynesia" => "French Polynesia",
            "French Southern Territories" => "French Southern Territories",
            "Gabon" => "Gabon",
            "Gambia" => "Gambia",
            "Georgia" => "Georgia",
            "Germany" => "Germany",
            "Ghana" => "Ghana",
            "Gibraltar" => "Gibraltar",
            "Greece" => "Greece",
            "Greenland" => "Greenland",
            "Grenada" => "Grenada",
            "Guadeloupe" => "Guadeloupe",
            "Guam" => "Guam",
            "Guatemala" => "Guatemala",
            "Guinea" => "Guinea",
            "Guinea-Bissau" => "Guinea-Bissau",
            "Guyana" => "Guyana",
            "Haiti" => "Haiti",
            "Heard Island and Mcdonald Islands" => "Heard Island and Mcdonald Islands",
            "Holy See (Vatican City State)" => "Holy See (Vatican City State)",
            "Honduras" => "Honduras",
            "Hong Kong" => "Hong Kong",
            "Hungary" => "Hungary",
            "Iceland" => "Iceland",
            "India" => "India",
            "Indonesia" => "Indonesia",
            "Iran, Islamic Republic of" => "Iran, Islamic Republic of",
            "Iraq" => "Iraq",
            "Ireland" => "Ireland",
            "Israel" => "Israel",
            "Italy" => "Italy",
            "Jamaica" => "Jamaica",
            "Japan" => "Japan",
            "Jordan" => "Jordan",
            "Kazakhstan" => "Kazakhstan",
            "Kenya" => "Kenya",
            "Kiribati" => "Kiribati",
            "Korea, Democratic People's Republic of" => "Korea, Democratic People's Republic of",
            "Korea, Republic of" => "Korea, Republic of",
            "Kuwait" => "Kuwait",
            "Kyrgyzstan" => "Kyrgyzstan",
            "Lao People's Democratic Republic" => "Lao People's Democratic Republic",
            "Latvia" => "Latvia",
            "Lebanon" => "Lebanon",
            "Lesotho" => "Lesotho",
            "Liberia" => "Liberia",
            "Libyan Arab Jamahiriya" => "Libyan Arab Jamahiriya",
            "Liechtenstein" => "Liechtenstein",
            "Lithuania" => "Lithuania",
            "Luxembourg" => "Luxembourg",
            "Macao" => "Macao",
            "Macedonia, the Former Yugoslav Republic of" => "Macedonia, the Former Yugoslav Republic of",
            "Madagascar" => "Madagascar",
            "Malawi" => "Malawi",
            "Malaysia" => "Malaysia",
            "Maldives" => "Maldives",
            "Mali" => "Mali",
            "Malta" => "Malta",
            "Marshall Islands" => "Marshall Islands",
            "Martinique" => "Martinique",
            "Mauritania" => "Mauritania",
            "Mauritius" => "Mauritius",
            "Mayotte" => "Mayotte",
            "Mexico" => "Mexico",
            "Micronesia, Federated States of" => "Micronesia, Federated States of",
            "Moldova, Republic of" => "Moldova, Republic of",
            "Monaco" => "Monaco",
            "Mongolia" => "Mongolia",
            "Montserrat" => "Montserrat",
            "Morocco" => "Morocco",
            "Mozambique" => "Mozambique",
            "Myanmar" => "Myanmar",
            "Namibia" => "Namibia",
            "Nauru" => "Nauru",
            "Nepal" => "Nepal",
            "Netherlands" => "Netherlands",
            "Netherlands Antilles" => "Netherlands Antilles",
            "New Caledonia" => "New Caledonia",
            "New Zealand" => "New Zealand",
            "Nicaragua" => "Nicaragua",
            "Niger" => "Niger",
            "Nigeria" => "Nigeria",
            "Niue" => "Niue",
            "Norfolk Island" => "Norfolk Island",
            "Northern Mariana Islands" => "Northern Mariana Islands",
            "Norway" => "Norway",
            "Oman" => "Oman",
            "Pakistan" => "Pakistan",
            "Palau" => "Palau",
            "Palestinian Territory, Occupied" => "Palestinian Territory, Occupied",
            "Panama" => "Panama",
            "Papua New Guinea" => "Papua New Guinea",
            "Paraguay" => "Paraguay",
            "Peru" => "Peru",
            "Philippines" => "Philippines",
            "Pitcairn" => "Pitcairn",
            "Poland" => "Poland",
            "Portugal" => "Portugal",
            "Puerto Rico" => "Puerto Rico",
            "Qatar" => "Qatar",
            "Reunion" => "Reunion",
            "Romania" => "Romania",
            "Russian Federation" => "Russian Federation",
            "Rwanda" => "Rwanda",
            "Saint Helena" => "Saint Helena",
            "Saint Kitts and Nevis" => "Saint Kitts and Nevis",
            "Saint Lucia" => "Saint Lucia",
            "Saint Pierre and Miquelon" => "Saint Pierre and Miquelon",
            "Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines",
            "Samoa" => "Samoa",
            "San Marino" => "San Marino",
            "Sao Tome and Principe" => "Sao Tome and Principe",
            "Saudi Arabia" => "Saudi Arabia",
            "Senegal" => "Senegal",
            "Serbia and Montenegro" => "Serbia and Montenegro",
            "Seychelles" => "Seychelles",
            "Sierra Leone" => "Sierra Leone",
            "Singapore" => "Singapore",
            "Slovakia" => "Slovakia",
            "Slovenia" => "Slovenia",
            "Solomon Islands" => "Solomon Islands",
            "Somalia" => "Somalia",
            "South Africa" => "South Africa",
            "South Georgia and the South Sandwich Islands" => "South Georgia and the South Sandwich Islands",
            "Spain" => "Spain",
            "Sri Lanka" => "Sri Lanka",
            "Sudan" => "Sudan",
            "Suriname" => "Suriname",
            "Svalbard and Jan Mayen" => "Svalbard and Jan Mayen",
            "Swaziland" => "Swaziland",
            "Sweden" => "Sweden",
            "Switzerland" => "Switzerland",
            "Syrian Arab Republic" => "Syrian Arab Republic",
            "Taiwan, Province of China" => "Taiwan, Province of China",
            "Tajikistan" => "Tajikistan",
            "Tanzania, United Republic of" => "Tanzania, United Republic of",
            "Thailand" => "Thailand",
            "Timor-Leste" => "Timor-Leste",
            "Togo" => "Togo",
            "Tokelau" => "Tokelau",
            "Tonga" => "Tonga",
            "Trinidad and Tobago" => "Trinidad and Tobago",
            "Tunisia" => "Tunisia",
            "Turkey" => "Turkey",
            "Turkmenistan" => "Turkmenistan",
            "Turks and Caicos Islands" => "Turks and Caicos Islands",
            "Tuvalu" => "Tuvalu",
            "Uganda" => "Uganda",
            "Ukraine" => "Ukraine",
            "United Arab Emirates" => "United Arab Emirates",
            "United Kingdom" => "United Kingdom",
            "United States" => "United States",
            "United States Minor Outlying Islands" => "United States Minor Outlying Islands",
            "Uruguay" => "Uruguay",
            "Uzbekistan" => "Uzbekistan",
            "Vanuatu" => "Vanuatu",
            "Venezuela" => "Venezuela",
            "Vietnam" => "Vietnam",
            "Virgin Islands, British" => "Virgin Islands, British",
            "Virgin Islands, U.s." => "Virgin Islands, U.s.",
            "Wallis and Futuna" => "Wallis and Futuna",
            "Western Sahara" => "Western Sahara",
            "Yemen" => "Yemen",
            "Zambia" => "Zambia",
            "Zimbabwe" => "Zimbabwe"
        );
        if ($userRole === 'customer') {
            $getID = $this->getRequest()->getAttribute('identity')->get('id');

            $this->viewBuilder()->setLayout('customerLayout');
            try {
                $user = $this->Users->get($id, [
                    'conditions' => ['id' => $getID],
                ]);


                if ($this->request->is(['patch', 'post', 'put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('The changes has been saved successfully.'));

                        return $this->redirect(['controller' => 'users', 'action' => 'retailer-profile']);
                    }
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }

                $this->set(compact('user'));

            } catch (Exception $e) {
                $this->Flash->error(__('Restricted view. You are not allowed to view this page.'));
                $this->redirect(['controller' => 'users', 'action' => 'edit', $getID]);
            }

        } else {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__(" Profile for : {0} {1} has been saved.", $user->first_name, $user->last_name));

                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                }
                $this->Flash->error(__('This profile could not be saved. Please, try again.'));
            }

        }
        $this->set(compact('user', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //restrict customer access to view a specific user
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to delete users'));
        } else {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user {0} {1} has been deleted.', $user->first_name, $user->last_name));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    public function beforeFilter(EventInterface $event)
    {
//         load the name of the controller and action to select which sidebar element to highlight
        if ($this->request->getParam('action') == 'userProfile' || $this->request->getParam('action') == 'retailerProfile') {
            $controller = "Dashboard";
            $this->set('controller', $controller);
        } else {
            $controller = "Users";
            $this->set('controller', $controller);
        }


        parent::beforeFilter($event);
        // Configure the login action to not require authentication
        // remove add once an admin record is entered
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);

    }

    public function login()
    {

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {

            $this->Flash->success(__('Successfully Logged In'));

            //to retrieve the role of the user being login
            $userRole = $this->getRequest()->getAttribute('identity')->get('role');
            if ($userRole == 'admin') {
                $redirect = $this->redirect(['controller' => 'users', 'action' => 'user_profile']);
            } else {
                $redirect = $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            }

            $this->Authentication->getAuthenticationService()->loadAuthenticator('Authentication.Cookie', [
                'fields' => [
                    'username' => 'email',
                    'password' => 'password',
                ]
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {

            $this->Flash->error(__('Unsuccessful login'));

            // for clearing the input fields
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
    }

    public function retailerProfile()
    {
        $this->set('title', 'Retailer Profile');
        $this->pageTitle = 'My Profile';

        $this->viewBuilder()->setLayout('customerLayout');

        $time = FrozenTime::now();
        $now = FrozenTime::parse('now');
        $_now = $now->i18nFormat('HH:mm');
        $this->set('timenow', $_now);

        $_date = $now->i18nFormat('yyyy-MM-dd');
        $this->set('date', $_date);


        $now = FrozenTime::parse('now');
        $nice = $now->nice();
        $this->set('nicetime', $nice);
        $hebrewdate = $now->i18nFormat(IntlDateFormatter::FULL);
        $this->set("hebrewdate", $hebrewdate);

        $time = FrozenTime::now();
        $this->set("current_year", $time->year);
        $this->set("current_month", $time->month);
        $this->set("current_day", $time->day);
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Successfully Logged Out'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }


    public function userProfile()
    {
        //restrict customer access to view list of users
        $userRole = $this->getRequest()->getAttribute('identity')->get('role');
        if ($userRole == 'customer') {
            $this->redirect(['controller' => 'users', 'action' => 'retailer_profile']);
            $this->Flash->error(__('You are not authorised to view this page'));
        } //
        //        admin is logged in
        else {
            $this->set('title', 'My Profile');
            $this->pageTitle = 'My Profile';
            $this->viewBuilder()->setLayout('default');

            $time = FrozenTime::now();
            $now = FrozenTime::parse('now');
            $_now = $now->i18nFormat('HH:mm');
            $this->set('timenow', $_now);

            $_date = $now->i18nFormat('yyyy-MM-dd');
            $this->set('date', $_date);

            $now = FrozenTime::parse('now');
            $nice = $now->nice();
            $this->set('nicetime', $nice);
            $hebrewdate = $now->i18nFormat(IntlDateFormatter::FULL);
            $this->set("hebrewdate", $hebrewdate);

            $time = FrozenTime::now();
            $this->set("current_year", $time->year);
            $this->set("current_month", $time->month);
            $this->set("current_day", $time->day);

//            Display a count of expiring inventory items to the card on the dashboard
            $this->loadModel('Inventories');
            $NewDate = new FrozenTime('6 month', 'Australia/Melbourne');
            $total = $this->Inventories->find()->where(['expiry_date <=' => $NewDate])->count();
            $this->set('inventoriesTotal', $total);

//            Display a count of understocked packaging to the card on the dashboard
            $this->loadModel('Packagings');
            $total = $this->Packagings->find()->where([
                'Packagings.total_quantity <= Packagings.rop'
            ])->count();
            $this->set('packagingsTotal', $total);

//          Display a count of understocked products to the card on the dashboard
            $this->loadModel('Products');

            $total = $this->Products->find()->where([
                'Products.total_quantity <= Products.rop'
            ])->count();
            $this->set('productsTotal', $total);

            //  Display a count of recent sales to the card on the dashboard
            $this->loadModel('Sales');
            $total = $this->Sales->find()->where(['status' => 'pending'])->count();
            $this->set('salesTotal', $total);

//            set the chart query
            $daysQuery = $this->request->getQuery('daysQuery');
            if (!$daysQuery) {
                $daysQuery = 30;
            }

            // date,  used to show recent orders since this date
            $startDate = new FrozenTime('-' . $daysQuery . ' days', 'Australia/Melbourne');

            // get the highest product_id from the sales table.
            $highestProductID = $this->Sales
                ->find()
                ->select(['product_id'])
                ->where(['sales_date >=' => $startDate])
                ->where(['status !=' => "canceled"])
                ->where(['status !=' => "pending"])
                ->order(['product_id' => 'DESC'])
                ->first();

            if (isset($highestProductID["product_id"])) {
                $maxID = $highestProductID["product_id"];
            } else {
                $maxID = 0;
            }


            //    retrieve all sales objects sorted by date ascending
            $chartSales = $this->Sales
                ->find()
                ->select(['sales_date', 'product_name', 'product_id', 'quantity'])
                ->where(['sales_date >=' => $startDate])
                ->where(['status !=' => "canceled"])
                ->where(['status !=' => "pending"])
                ->order(['sales_date' => 'ASC']);

            $this->set(compact( 'daysQuery', 'chartSales', 'maxID'));

        }
    }

    /**
     * Forgot password method
     *
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function forgot()
    {
        if ($this->request->is(['post'])) {
            $myEmail = $this->request->getData('email');
            $userTable = TableRegistry::getTableLocator()->get('Users');
            $user = $userTable->find('all')->where(['email' => $myEmail])->first();

            //Display error if an email is not found in the system
            if ($user == null) {
                $this->Flash->error(__('Email not found, please ensure that your email is correct.'));

                // for clearing the input fields
                return $this->redirect(['controller' => 'users', 'action' => 'forgot']);
            }
//            $token = $this->request->getAttribute('csrfToken');
            $session = $this->request->getSession();
            $session->write('id', $user->id);
//            debug($session->read('id'));
//            exit();
            if ($user->role == 'admin') {
                // Send "Reset Password" email
                $mailer = new Mailer('default');
                // Setup email parameters
                $mailer
                    ->setEmailFormat('html')
                    ->setTo(Configure::read('sendEmail.to'))
                    ->setFrom(Configure::read('sendEmail.from'))
                    ->setSubject('Reset your password')
                    ->viewBuilder()
                    ->disableAutoLayout()
                    ->setTemplate('forgot');

                // Send data to the email template
                $mailer->setViewVars([
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email
//                    'token' => $token
                ]);
                //Send email
                $email_result = $mailer->deliver();

                if ($email_result) {
                    $this->Flash->success(__('A reset password email has been sent to your email account.'));
                } else {
                    $this->Flash->error(__('Email failed to send. Please try again later.'));
                }
//               customer email account
            } else {
                // Send "Reset Password" email
                $mailer = new Mailer('default');
                // Setup email parameters
                $mailer
                    ->setEmailFormat('html')
                    ->setTo($user->email)
                    ->setFrom(Configure::read('sendEmail.from'))
                    ->setSubject('Reset your password')
                    ->addHeaders(['Testing header'])
                    ->viewBuilder()
                    ->disableAutoLayout()
                    ->setTemplate('forgot');

                // Send data to the email template
                $mailer->setViewVars([
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email
//                        'token' => $token
                ]);
                //Send email
                $email_result = $mailer->deliver();

                if ($email_result) {
                    $this->Flash->success(__('A reset password email has been sent to your email account.'));
                } else {
                    $this->Flash->error(__('Email failed to send. Please try again later.'));
                }
//
            }
            return $this->redirect(['action' => 'login']);
        }

    }


    /**
     * Reset password method
     *
     * @param string|null $token User id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function reset()
    {
        $session = $this->request->getSession();
//        debug($session->read('id'));
//        exit();
        $getID = $session->read('id');
        $user = $this->Users->get($getID, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The new password has been saved.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The new password could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

}
