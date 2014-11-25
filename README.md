# LDAPBundle

This bundle integrates the ccottet/ldap library into Symfony 2. You could use this to implement your own LdapAuthentication into your project. 

## Configuration
```yaml
agixo_ldap:
    driver:
        host: localhost
        baseDn: 'dc=example,dc=com'
        bindDn: 'cn=users,dc=example,dc=com'
        loginAttribute: uid
        port: 389
```

## Using LDAP

### Controller
In your controller you can get access to ldap. To check login data against LDAP you could do:

```
$this->get('ldap.manager')->checkPassword($username, $password)
```
