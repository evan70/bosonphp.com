Feature: GET /v1/doc/versions
    Background:
        Given empty database
        And request is json
        And request uri is "/v1/doc/versions"

    Scenario: No versions
        When I send request
        Then response is not found
        And response is json
        And response matches the schema file "../error.v1.json"

    Scenario: With ONE hidden version
        Given hidden version "master"
        When I send request
        Then response is not found
        And response is json
        And response matches the schema file "../error.v1.json"

    Scenario: With ONE deprecated version
        Given deprecated version "master"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 0 elements
        And json path "$.data.stable" is array with 0 elements
        And json path "$.data.deprecated" is array with 1 element
        And json path "$.data.current.version" is "{{ version.current.name }}"
        And json path "$.data.deprecated[0].version" is "{{ version.current.name }}"

    Scenario: With ONE dev version
        Given dev version "master"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 1 elements
        And json path "$.data.stable" is array with 0 elements
        And json path "$.data.deprecated" is array with 0 element
        And json path "$.data.current.version" is "{{ version.current.name }}"
        And json path "$.data.dev[0].version" is "{{ version.current.name }}"

    Scenario: With ONE stable version
        Given stable version "master"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.current.version" is "{{ version.current.name }}"
        And json path "$.data.dev" is array with 0 elements
        And json path "$.data.stable" is array with 1 elements
        And json path "$.data.deprecated" is array with 0 element
        And json path "$.data.stable[0].version" is "{{ version.current.name }}"
