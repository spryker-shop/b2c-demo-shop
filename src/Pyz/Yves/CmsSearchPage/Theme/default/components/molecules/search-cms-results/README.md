Displays a list of search results with links (to CMS page) in the search page.

## Code sample

```
{% include molecule('search-cms-results', 'CmsSearchPage') with {
    data: {
        pages: data.pages
    }
} only %}
```
