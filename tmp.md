# 在终端中执行
export https_proxy=http://127.0.0.1:53373
export http_proxy=http://127.0.0.1:53373
git config --global http.proxy 'http://127.0.0.1:53373'
git config --global https.proxy 'http://127.0.0.1:53373'

`npm install` saves any specified packages into `dependencies` by default.
Additionally, you can control where and how they get saved with some
additional flags:

* `-P, --save-prod`: Package will appear in your `dependencies`. This is the
                     default unless `-D` or `-O` are present.

* `-D, --save-dev`: Package will appear in your `devDependencies`.

* `-O, --save-optional`: Package will appear in your `optionalDependencies`.

* `--no-save`: Prevents saving to `dependencies`.

When using any of the above options to save dependencies to your
package.json, there are two additional, optional flags:

* `-E, --save-exact`: Saved dependencies will be configured with an
  exact version rather than using npm's default semver range
  operator.

* `-B, --save-bundle`: Saved dependencies will also be added to your `bundleDependencies` list.

Further, if you have an `npm-shrinkwrap.json` or `package-lock.json` then it
will be updated as well.

`<scope>` is optional. The package will be downloaded from the registry
associated with the specified scope. If no registry is associated with
the given scope the default registry is assumed. See [`scope`](/cli/v6/using-npm/scope).

Note: if you do not include the @-symbol on your scope name, npm will
interpret this as a GitHub repository instead, see below. Scopes names
must also be followed by a slash.

Examples:

```bash
npm install sax
npm install githubname/reponame
npm install @myorg/privatepackage
npm install node-tap --save-dev
npm install dtrace-provider --save-optional
npm install readable-stream --save-exact
npm install ansi-regex --save-bundle
```

**Note**: If there is a file or folder named `<name>` in the current
working directory, then it will try to install that, and only try to
fetch the package by name if it is not valid.