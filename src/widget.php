<?php
namespace test;
defined('LIB_ROOT') or die();
/**
 * Class Widget
 * example widget class
 */
class Widget extends \Helpers\Widgets{
	protected function endpoint_get(){
		//to get widget lang value based on account setting
		//\Helpers\Debug::vars(\Helpers\I18n::get('settings.enums.yes'));
		/**
		 * current account information
		 */
		//\Helpers\Debug::vars($this->account->current(),'account');

		/**
		 * get methods
		 * array with available params
		 */
		$params = array(
			//'since'=>time()-36000, //since what time get elements (only timestamp)
			//'limit'=>10, //limitation of response elements (max 500)
			//'offset'=>0, //limit offset
			//'id'=>2000308, //take element from account with this id (if this param exists all others are skipping)
			//'query'=>'test', //search element by query (you can search by email or phone or any other fields, except notes and tasks
			//'type'=>'contact', //or lead - this param only require for notes selection, but also available for tasks
			//'element_id'=> 5282604 //contact or lead id - only for notes or tasks selection
			//'status'=>array(26264,142), //only for leads - id of lead's statuses you can find in $this->account->current('leads_statuses)
			//'responsible_user_id'=>array(52,8), //for contacts,leads and tasks - set additional filter for responsible user(s)

		);
		//\Helpers\Debug::vars($this->contacts->get($params),'contacts');
		//\Helpers\Debug::vars($this->leads->get($params),'leads');
		//\Helpers\Debug::vars($this->tasks->get($params),'tasks');
		//\Helpers\Debug::vars($this->notes->get($params), 'notes');
	}

	protected function endpoint_set(){

		/**
		 * contacts set example
		 */
		$request = array(
						'add'=>array(),
						'update'=>array()
						);

		$request['add'][] = array(
								'name' => 'test_widget_'.rand(0,9999999),
								//'date_create'=>1298904164, //optional
								//'last_modified' => 1298904164, //optional
								'linked_leads_id' => array( //array of linked leads ids
														2000309,
														2000042
														),
								'company_name' => 'amowidget',
								'custom_fields' => array(
														array(
															'id' => 9536, //custom field id
															'values' => array(
																			array(
																					'value' => rand(0,999).'-'.rand(0,99).'-'.rand(0,99),
																					//enum for phone,email and im must be symbolic, for others numeric
																					//(all enums are in account description)
																					//see $this->account->current('custom_fields')
																					'enum' => 'MOB',
																					),
																			array(
																				'value' => rand(0,999).'-'.rand(0,99).'-'.rand(0,99),
																				'enum' => 'MOB',
																			),
																			array(
																				'value' => '7('.rand(0,999).')'.rand(0,999).'-'.rand(0,99).'-'.rand(0,99),
																				'enum' => 'HOME',
																			),
																		),
															),
														array(
															'id' => 9540, //custom field id
															'values' => array(
																			array(
																				'value' => rand(0,999).'@mail.com',
																				//enum for phone,email and im must be symbolic, for others numeric
																				//(all enums are in account description)
																				//see $this->account->current('custom_fields')
																				'enum' => 'WORK',
																			),
																			array(
																				'value' => rand(0,999).'@mail.com',
																				'enum' => 'PRIV',
																			),
																			array(
																				'value' => rand(0,999).'@mail.com',
																				'enum' => 'OTHER',
																			),
															),
														),
														array(
															'id' => 9538,
															'values' => array(
																			0 => array(
																					'value' => str_shuffle('qwertyuiopasdfghjklzxcvbnm').' '.rand(0,999999).str_shuffle('qwertyuiopasdfghjklzxcvbnm')
																			)
															)
														),
														array(
															'id' => 9534,
															'values' => array(
																			0 => array(
																					'value' => str_shuffle('qwertyuio\'"pasdfghjklzxcvbnm').'.com'
																					)
																			)
															),
														//select field must contain value from enums list (ONLY ONE), otherwise api will take first one
														array(
															'id' => 334046,
															'values' => array(
																			0 => array(
																					'value' => 'list3',
																					)
																			)
														),
														array(
															'id' => 424776,
															'values' => array(
																			0 => array(
																					'value' => 5555
																					)
																			)
															),
														)
								);

		$request['update'][] = array(
									'id'=>1232810,
									'last_modified'=>time(),//if last modified is lower than in amoCRM DB, then it will not rewrite, but will return what it have
									'responsible_user_id'=>23305,
									'linked_leads_id'=>array(
															199402
															)
									//other fields fills same as for add
									);

		//\Helpers\Debug::vars($this->contacts->set($request));

		/**
		 * notes set example
		 */
		$request = array(
						/*'add'=>array(
									array(
										'element_id' => 8000651, //contact/lead id
										'element_type' => $this->_types['contacts'], //contact/lead type - can be found in variable $this->_types['contacts'] or $this->_types['leads']
										'note_type' => 4, //available note's types you can find in $this->account->current('note_types'),
										'date_create'=>time()-360000, //optional field
										//'last_modified'=>time(), //optional field
										'text' => 'amowidget note test common '.rand(0,99999)
									),
									array(
										'element_id' => 2000309,
										'element_type' => $this->_types['leads'],
										'note_type' => 4,
										'text' => 'amowidget note for lead '.rand(0,99999)
									),
								),*/
						'update'=>array(
										array (
											'id' => 1088098,
											'element_id' => 200808,
											'element_type' => $this->_types['leads'],
											'note_type' => 4,
											'last_modified' =>time(), //if last modified is lower than in amoCRM DB, then it will not rewrite, but will return what it have
											'text' => "Test update \n alalalala",
								            ),
									)
						);
		//\Helpers\Debug::vars($this->notes->set($request));

		/**
		 * tasks set example
		 */
		$request = array(
						'add'=>array(
									array(
										'element_id' => 8000651, //contact/lead id
										'element_type' => $this->_types['contacts'], //contact/lead type - can be found in variable $this->_types['contacts'] or $this->_types['leads']
										//'date_create'=>time()-360000, //optional field
										//'last_modified'=>time(), //optional field
										'task_type'=>2233, //can be found in $this->account->current('task_types'), can be CALL,LETTER,MEETING or id of task_type
										'text' => 'amowidget task test mmmm custom '.rand(0,99999),
										'complete_till'=>time()-360000
									),
									array(
										'element_id' => 2000309,
										'element_type' => $this->_types['leads'],
										'task_type'=>'LETTER',
										'text' => 'amowidget task test LETTER '.rand(0,99999),
										'complete_till'=>time()+3600*24
									),
						),
						'update'=>array(
									array (
										'id' => 402362,
										'element_id' => 128962,
										'element_type' => $this->_types['leads'],
										'task_type'=>'MEETING',
										'last_modified' =>time(), //if last modified is lower than in amoCRM DB, then it will not rewrite, but will return what it have
										'text' => 'Meet that guy',
										'complete_till'=>time()+36000
									),
						)
					);
		//\Helpers\Debug::vars($this->tasks->set($request));

		/**
		 * leads set example
		 */
		$request = array(
						'add'=>array(
									array(
										'name' => 'amowidget_phar_'.rand(0,99999),
										//'date_create'=>time()-360000, //optional
										'status_id' => 26267, //optional - default first account status - list of statuses $this->account->current('leads_statuses')
										'price' => 500000,
										'custom_fields' => array(
																array(
																	'id' => 290642,
																	'values' => array(
																		0 => array(
																			'value' => str_shuffle('qwert\'"yuiopasdfghjklzxcvbnm').' '.rand(0,999999).str_shuffle('qwertyuiopasdfghjklzxcvbnm')
																		)
																	)
																),
																array(
																	'id' => 966,
																	'values' => array(
																		0 => array(
																			'value' => str_shuffle('qwertyuiopasdfghjklzxcvbnm').'.com'
																		)
																	)
																),
																//select field must contain value from enums list (ONLY ONE), otherwise api will take first one
																array(
																	'id' => 968,
																	'values' => array(
																		0 => array(
																			'value' => 'amocrm_'.rand(0,9999),
																		)
																	)
																),
																array(
																	'id' => 309752,
																	'values' => array(
																		0 => array(
																			'value' => 1
																		)
																	)
																),
																array(
																	'id' => 340947,
																	'values' => array(
																		0 => array(
																			'value' => 'radio3'
																		)
																	)
																),
															)
										),
									),
						'update'=>array(
									array(
										'id'=>2000322,
										'name' => 'amowidget_lead_upd_'.rand(0,9999),
										'status_id' => 142, //optional
										'last_modified' => time(), //if last modified is lower than in amoCRM DB, then it will not rewrite, but will return what it have
										'price' => rand(10000,9999999),
										'custom_fields' => array(
																array(
																	'id' => 290642,
																	'values' => array(
																		0 => array(
																			'value' => str_shuffle('qwert\'"yuiopasdfghjklzxcvbnm').' '.rand(0,999999).str_shuffle('qwertyuiopasdfghjklzxcvbnm')
																		)
																	)
																),
																array(
																	'id' => 966,
																	'values' => array(
																		0 => array(
																			'value' => str_shuffle('qwertyuiopasdfghjklzxcvbnm').'.com'
																		)
																	)
																),
																//select field must contain value from enums list (ONLY ONE), otherwise api will take first one
																array(
																	'id' => 968,
																	'values' => array(
																		0 => array(
																			'value' => 'amocrm_'.rand(0,9999),
																		)
																	)
																),
																array(
																	'id' => 309752,
																	'values' => array(
																		0 => array(
																			'value' => 1
																		)
																	)
																),
																array(
																	'id' => 340947,
																	'values' => array(
																		0 => array(
																			'value' => 'radio3'
																		)
																	)
																),
															)
										)
									)
						);
		//\Helpers\Debug::vars($this->leads->set($request));

	}
}
