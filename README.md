# Arbiter

A customizable rule tree system. 
Allows for a set of rules (_RuleBook_) 
to be evaluated based on a context (_ContextContract_) in the 
proper order of dependencies.

## Contracts
- _ArbiterContract_
    - Contains the Context
    - Initializes Rulebooks
    - Delegates Rule evaluation
    - Issues Results
- _ContextContract_
    - Provides data to be evaluated
    - Assumed as immutable as possible
- _ResultContract_
    - Carries the result of the evaluation
    - Reports one or many failed rules
    - Forwards the Context used for evaluation
- _RuleContract_
    - Defines what is to be evaluated
    - Requires a context
    - Signed by a hash of it's class and parameters
    - Parameters are normalized
- _SourceRuleContract_
    - Helper contract
    - Gives the source of a single value from the context