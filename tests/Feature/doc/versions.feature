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

    Scenario: With multiple versions of different types
        Given stable version "1.0"
        And dev version "2.0"
        And deprecated version "0.9"
        And hidden version "0.8"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 1 elements
        And json path "$.data.stable" is array with 1 elements
        And json path "$.data.deprecated" is array with 1 element
        And json path "$.data.current.version" is "1.0"
        And json path "$.data.dev[0].version" is "2.0"
        And json path "$.data.stable[0].version" is "1.0"
        And json path "$.data.deprecated[0].version" is "0.9"

    Scenario: With multiple stable versions - current should be latest
        Given stable version "1.0"
        And stable version "2.0"
        And stable version "1.5"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 0 elements
        And json path "$.data.stable" is array with 3 elements
        And json path "$.data.deprecated" is array with 0 element
        And json path "$.data.current.version" is "2.0"
        And json path "$.data.stable[0].version" is "2.0"
        And json path "$.data.stable[1].version" is "1.5"
        And json path "$.data.stable[2].version" is "1.0"

    Scenario: With multiple dev versions - current should be latest
        Given dev version "1.0"
        And dev version "2.0"
        And dev version "1.5"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 3 elements
        And json path "$.data.stable" is array with 0 elements
        And json path "$.data.deprecated" is array with 0 element
        And json path "$.data.current.version" is "2.0"
        And json path "$.data.dev[0].version" is "2.0"
        And json path "$.data.dev[1].version" is "1.5"
        And json path "$.data.dev[2].version" is "1.0"

    Scenario: With multiple deprecated versions - current should be latest stable
        Given deprecated version "0.8"
        And deprecated version "0.9"
        And stable version "1.0"
        And deprecated version "0.7"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 0 elements
        And json path "$.data.stable" is array with 1 elements
        And json path "$.data.deprecated" is array with 3 elements
        And json path "$.data.current.version" is "1.0"
        And json path "$.data.stable[0].version" is "1.0"
        And json path "$.data.deprecated[0].version" is "0.9"
        And json path "$.data.deprecated[1].version" is "0.8"
        And json path "$.data.deprecated[2].version" is "0.7"

    Scenario: With dev and stable versions - current should be stable
        Given dev version "2.0"
        And stable version "1.0"
        And dev version "1.5"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 2 elements
        And json path "$.data.stable" is array with 1 elements
        And json path "$.data.deprecated" is array with 0 element
        And json path "$.data.current.version" is "1.0"
        And json path "$.data.dev[0].version" is "2.0"
        And json path "$.data.dev[1].version" is "1.5"
        And json path "$.data.stable[0].version" is "1.0"

    Scenario: With only deprecated versions - current should be latest deprecated
        Given deprecated version "0.8"
        And deprecated version "0.9"
        And deprecated version "0.7"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 0 elements
        And json path "$.data.stable" is array with 0 elements
        And json path "$.data.deprecated" is array with 3 elements
        And json path "$.data.current.version" is "0.9"
        And json path "$.data.deprecated[0].version" is "0.9"
        And json path "$.data.deprecated[1].version" is "0.8"
        And json path "$.data.deprecated[2].version" is "0.7"

    Scenario: With mixed versions and hidden versions
        Given stable version "1.0"
        And dev version "2.0"
        And deprecated version "0.9"
        And hidden version "0.8"
        And hidden version "3.0"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 1 elements
        And json path "$.data.stable" is array with 1 elements
        And json path "$.data.deprecated" is array with 1 element
        And json path "$.data.current.version" is "1.0"
        And json path "$.data.dev[0].version" is "2.0"
        And json path "$.data.stable[0].version" is "1.0"
        And json path "$.data.deprecated[0].version" is "0.9"

    Scenario: Verify response structure and version field
        Given stable version "1.0"
        And dev version "2.0"
        And deprecated version "0.9"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.version" is "1.0"
        And json path "$.data" is object
        And json path "$.data.current" is object
        And json path "$.data.dev" is array
        And json path "$.data.stable" is array
        And json path "$.data.deprecated" is array
        And json path "$.data.current.version" is string
        And json path "$.data.dev[0].version" is string
        And json path "$.data.stable[0].version" is string
        And json path "$.data.deprecated[0].version" is string

    Scenario: With complex version numbering
        Given stable version "1.0.0"
        And dev version "2.0.0-beta"
        And deprecated version "0.9.5"
        And stable version "1.1.0"
        And dev version "1.9.0"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And json path "$.data.dev" is array with 2 elements
        And json path "$.data.stable" is array with 2 elements
        And json path "$.data.deprecated" is array with 1 element
        And json path "$.data.current.version" is "1.1.0"
        And json path "$.data.dev[0].version" is "2.0.0-beta"
        And json path "$.data.dev[1].version" is "1.9.0"
        And json path "$.data.stable[0].version" is "1.1.0"
        And json path "$.data.stable[1].version" is "1.0.0"
        And json path "$.data.deprecated[0].version" is "0.9.5"
