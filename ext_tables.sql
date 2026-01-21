#
# Table structure for table 'tx_process_domain_model_layer'
#
CREATE TABLE tx_process_domain_model_layer (

	title varchar(255) NOT NULL,
	elements varchar(255) NOT NULL,
	description text,
	image int(11) NOT NULL,
	parent_entity int(11) NOT NULL

);

#
# Table structure for table 'tx_process_domain_model_element'
#
CREATE TABLE tx_process_domain_model_element (
	title varchar(255) NOT NULL,
	fieldtype varchar(255) NOT NULL,
	description text
);

#
# Table structure for table 'tx_process_domain_model_elementvalue'
#
CREATE TABLE tx_process_domain_model_elementvalue (
	object_id int(11) NOT NULL,
	entity_id int(11) NOT NULL,
	element_id int(11) NOT NULL,
	value varchar(255) NOT NULL
);

#
# Table structure for table 'tx_process_domain_model_entity'
#
CREATE TABLE tx_process_domain_model_entity (
	title varchar(255) NOT NULL,
	state varchar(255) NOT NULL
);