
drop table if exists wawe_list_portals;

create table if not exists wawe_list_portals
(
    id int(11) not null auto_increment,
    date_create datetime default CURRENT_TIMESTAMP,
    active int(2) null default 1,
    use_local_install int(2) null default 0,
    c_rest_client_id varchar(255) null default '',
    c_rest_client_secret varchar(255) null default '',
    portal_domain varchar(255) not null,
    client_endpoint varchar(255) not null,
    lang varchar(5) null default '',
    access_token varchar(255) not null,
    refresh_token varchar(255) not null,
    member_id varchar(255) null default '',
    application_token varchar(255) null default '',
    status varchar(5) null default '',
    protocol varchar(5) null default '',
    placement varchar(50) null default '',
    placement_options varchar(255) null default '',
    wawe_client_id varchar(255) null default '',
    wawe_client_secret varchar(255) null default '',
    wawe_access_token varchar(255) null default '',
    wawe_token_type varchar(255) null default '',
    wawe_scope varchar(255) null default '',
    wawe_refresh_token varchar(255) null default '',
    wawe_grant_type varchar(255) null default '',
    wawe_userId varchar(255) null default '',
    wawe_businessId varchar(255) null default '',
    wawe_state varchar(50) null default '',
    PRIMARY KEY wawe_portals_primary_id (ID)
)