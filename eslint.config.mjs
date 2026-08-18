import typescriptEslint from '@typescript-eslint/eslint-plugin';
import typescriptParser from '@typescript-eslint/parser';
import deprecationPlugin from 'eslint-plugin-deprecation';
import { createRequire } from 'module';

const require = createRequire(import.meta.url);
const sprykerConfig = require('@spryker/frontend-config.eslint/.eslintrc.js');

export default [
    {
        ignores: [
            'docker/',
            'public/*/assets/',
            '**/dist/',
            '**/node_modules/',
            'vendor/',
            'src/Pyz/Zed/*/Presentation/Components/',
        ],
    },
    // Configuration for regular JS files
    {
        files: ['**/*.js'],
        languageOptions: {
            ecmaVersion: 2020,
            sourceType: 'module',
            globals: {
                ...sprykerConfig.globals,
            },
        },
        rules: {
            ...sprykerConfig.rules,
            'accessor-pairs': [
                'error',
                {
                    setWithoutGet: true,
                    enforceForClassMembers: false,
                },
            ],
        },
    },
    // Configuration for Yves TypeScript files
    {
        files: ['src/Pyz/Yves/**/*.ts'],
        languageOptions: {
            parser: typescriptParser,
            parserOptions: {
                ecmaVersion: 2020,
                sourceType: 'module',
                project: ['./tsconfig.yves.json'],
            },
            globals: {
                ...sprykerConfig.globals,
            },
        },
        plugins: {
            '@typescript-eslint': typescriptEslint,
            deprecation: deprecationPlugin,
        },
        rules: {
            ...sprykerConfig.rules,
            'no-undef': 'off',
            'no-unused-vars': 'off',
            'accessor-pairs': [
                'error',
                {
                    setWithoutGet: true,
                    enforceForClassMembers: false,
                },
            ],
            '@typescript-eslint/no-unused-vars': [
                'error',
                {
                    args: 'none',
                    ignoreRestSiblings: true,
                },
            ],
            '@typescript-eslint/no-empty-function': [
                'error',
                {
                    allow: ['methods'],
                },
            ],
            '@typescript-eslint/no-magic-numbers': [
                'error',
                {
                    ignore: [-1, 0, 1],
                    ignoreDefaultValues: true,
                    ignoreClassFieldInitialValues: true,
                    ignoreArrayIndexes: true,
                    ignoreEnums: true,
                    ignoreReadonlyClassProperties: true,
                },
            ],
        },
    },
];
